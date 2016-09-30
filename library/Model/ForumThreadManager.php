<?php
namespace Model;

use Core\Manager;

/**
 * Class ForumThreadManager
 *
 * Modélise le Manager des entités Thread.
 * Permet d'intéragir avec la base de données pour échanger des informations sur les Threads
 */
class ForumThreadManager extends Manager
{
    /**
     * Méthode permettant de récupérer une instance d'un Thread correspondand à un slug en particulier.
     *
     * @param $slug Le slug du Thread à récupérer
     * @return mixed Le Thread correspondant au slug
     */
    public function getThreadBySlug($slug)
    {
        $query = $this->db->prepare("
			SELECT * 
			FROM myshop_forum_thread 
			WHERE slug = :slug 
		");
        $query->bindValue(':slug', $slug, \PDO::PARAM_STR);
        $query->execute();
    
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Forum\ForumThread');
        
        return $query->fetch();
    }
    
    public function getThreadsFromSection($section_id, $limit_start, $nbPerPage, $sort_order)
    {
        $query = $this->db->prepare("
			SELECT * 
			FROM myshop_forum_thread 
			WHERE id_section = :id 
			ORDER BY created_at $sort_order 
			LIMIT $limit_start,$nbPerPage
		");
        $query->bindValue(':id', $section_id, \PDO::PARAM_INT);
        $query->execute();
    
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Forum\ForumThread');
        
        return $query->fetchAll();
    }
    
    /**
     * Méthode qui renvoie le Thread demandé ainsi que ses Posts dans les limites indiquée
     * (pour la pagination)
     *
     * @param $threadSlug Le slug du Thread à récupérer
     * @param $page Le numéro de la page à afficher
     * @param $nbPerPage Le nombre de Posts à afficher sur une page
     *
     * @throws \InvalidArgumentException Une exception levée lorsque le slug passé en paramètre ne
     * correspond à aucun Thread dans la base de données
     *
     * @return \Entity\ForumThread Le Thread demandé
     */
    public function getThreadWithPosts($threadSlug, $page, $nbPerPage)
    {
        /**
         * ETAPE 1 : On récupère le Thread
         * Si le Thread n'existe pas, on lève une exception
         */
        $thread = $this->getThreadBySlug($threadSlug);
        if (!$thread) {
            throw new \InvalidArgumentException('La discussion demandée n\'existe pas.');
        }
        
        /**
         * ETAPE 2 : On récupère les Posts du Thread
         * On calcule d'abord le premier message à afficher pour la pagination
         * Puis on récupère les posts en fonction du nombre par page défini en config
         */
        $limit_start = $nbPerPage * ($page - 1);
        $manager = new ForumPostManager($this->db);
        $posts = $manager->getPostsFromThread($thread->getId(), $limit_start, $nbPerPage, 'ASC');

        /**
         * ETAPE 3 : On récupère l'auteur et le modérateur de chaque Post et on lie chacune des
         * entités au Post
         */
        foreach ($posts as $post) {
            // On récupère l'auteur et le modérateur
            $manager = new MemberManager($this->db);
            $author = $manager->getMemberById($post->getCreatedByIdMember());
            $moderator = $manager->getMemberById($post->getUpdatedByIdMember());

            // On lie les entités au Post
            $post->setAuthor($author);
            $post->setModerator($moderator);

            // On ajoute le Post au Thread
            $thread->addPost($post);
        }

        /**
         * ETAPE 4 : On récupère la Section du Thread et on la lie
         */
        $manager = new ForumSectionManager($this->db);
        $section = $manager->getSectionById($thread->getIdSection());
        $thread->setSection($section);


        return $thread;
    }
}
