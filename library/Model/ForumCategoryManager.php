<?php
namespace Model;

use Core\Manager;

/**
 * Class ForumCategoryManager
 *
 * Modélise le Manager des entités Category.
 * Permet d'intéragir avec la base de données pour échanger des informations sur les Catégories
 */
class ForumCategoryManager extends Manager
{
    /**
     * Renvoie un tableau contenant toutes les Catégories du Forum ainsi que les sections liées
     * @return array Les catégories du forum et leurs sections
     */
    public function getCategoriesWithSections()
    {
        // On récupère les catégories
        $query = $this->db->query('SELECT * FROM myshop_forum_category ORDER BY position_weight ASC');
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Forum\ForumCategory');
        $categories = $query->fetchAll();
        
        // On récupère les sections
        $query = $this->db->query('SELECT * FROM myshop_forum_section');
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Forum\ForumSection');
        $sections = $query->fetchAll();
        
        // On joint les sections aux categories correspondantes
        foreach ($sections as $section) {
            foreach ($categories as $category) {
                if ($section->getIdCategory() === $category->getId()) {
                    $category->addSection($section);
                    break;
                }
            }
        }
        
        return $categories;
    }
}
