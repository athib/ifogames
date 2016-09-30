<?php
namespace Model;

use Core\Manager;

/**
 * Class ForumSectionManager
 *
 * Modélise le Manager des entités Sections.
 * Permet d'intéragir avec la base de données pour échanger des informations sur les Sections
 */
class ForumSectionManager extends Manager
{
    /**
     * Méthode permettant de récupérer une instance d'une Section correspondante à un ID.
     *
     * @param $id Le slug de la Section à récupérer
     * @return mixed La Section correspondante àl'ID
     */
    public function getSectionById($id)
    {
        $query = $this->db->prepare("
			SELECT * 
			FROM myshop_forum_section 
			WHERE id_section = :id 
		");
        $query->bindValue(':id', $id, \PDO::PARAM_STR);
        $query->execute();
        
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Forum\ForumSection');
        
        return $query->fetch();
    }
    
    /**
     * Méthode permettant de récupérer une instance d'une Section correspondante à un slug.
     *
     * @param $slug Le slug de la Section à récupérer
     * @return mixed La Section correspondante au slug
     */
    public function getSectionBySlug($slug)
    {
        $query = $this->db->prepare("
			SELECT * 
			FROM myshop_forum_section 
			WHERE slug = :slug 
		");
        $query->bindValue(':slug', $slug, \PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Forum\ForumSection');

        return $query->fetch();
    }
    
    /**
     * Méthode qui renvoie la Section demandée ainsi que ses Threads dans les limites indiquée
     * (pour la pagination)
     *
     * @param $section_slug Le slug de la Section à récupérer
     * @param $page Le numéro de la page à afficher
     * @param $nbPerPage Le nombre de Threads à afficher sur une page
     *
     * @throws \InvalidArgumentException Une exception levée lorsque le slug passé en paramètre ne
     * correspond à aucune Section dans la base de données
     *
     * @return \Entity\ForumSection La section demandée
     */
    public function getSectionWithThreads($section_slug, $page, $nbPerPage)
    {
        /**
         * ETAPE 1 : On récupère la Section
         * Si elle n'existe pas, on lève une exception
         */
        $section = $this->getSectionBySlug($section_slug);
        if (!$section) {
            throw new \InvalidArgumentException('La rubrique demandée n\'existe pas.');
        }
    
        /**
         * ETAPE 2 : On récupère les Threads de la Section
         * On calcule d'abord le premier thread à afficher pour la pagination
         * Puis on récupère les threads en fonction du nombre par page défini en config
         */
        $limit_start = $nbPerPage * ($page - 1);
        $manager = new ForumThreadManager($this->db);
        $threads = $manager->getThreadsFromSection($section->getId(), $limit_start, $nbPerPage, 'DESC');
    
        /**
         * ETAPE 3 : On récupère l'auteur du thread et lie les entités (Section, Threads, auteur) entre elles
         */
        foreach ($threads as $thread) {
            // On récupère l'auteur et le modérateur
            $manager = new MemberManager($this->db);
            $author = $manager->getMemberById($thread->getCreatedByIdMember());
            $moderator = $manager->getMemberById($thread->getUpdatedByIdMember());

            // On lie les entités au Thread
            $thread->setAuthor($author);
            $thread->setModerator($moderator);

            // On lie le thread à la section
            $section->addThread($thread);
        }
        
        return $section;
    }
}
