<?php
namespace Model;

use Core\Manager;
use Entity\Forum\ForumPost;

/**
 * Class ForumPostManager
 *
 * Modélise le Manager des entités Post.
 * Permet d'intéragir avec la base de données pour échanger des informations sur les Catégories
 */
class ForumPostManager extends Manager
{
    /**
     * Renvoie un tableau contenant toutes les Catégories du Forum ainsi que les sections liées
     * @return array Les catégories du forum et leurs sections
     */
    public function getPostsFromThread($thread_id, $limit_start, $nbPerPage, $sort_order)
    {
        $query = $this->db->prepare("
			SELECT * 
			FROM myshop_forum_post 
			WHERE id_thread = :id 
			ORDER BY created_at $sort_order 
			LIMIT $limit_start,$nbPerPage
		");
        $query->bindValue(':id', $thread_id, \PDO::PARAM_INT);
        $query->execute();
    
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Forum\ForumPost');
        
        return $query->fetchAll();
    }
    
    /**
     * Méthode qui enregistre un Post en base de données
     * @param ForumPost $post Le post à enregistrer
     */
    public function save(ForumPost $post)
    {
        try {
            // Nouveau Post -> Insertion
            if ($post->isNew()) {
                $query = $this->db->prepare(
                    "INSERT INTO myshop_forum_post (content, created_at, created_by_id_member, id_thread) 
                    VALUES (:content, NOW(), :author, :id_thread)"
                );

                $query->bindValue(':content', $post->getContent(), \PDO::PARAM_STR);
                $query->bindValue(':author', $post->getCreatedByIdMember(), \PDO::PARAM_INT);
                $query->bindValue(':id_thread', $post->getIdThread(), \PDO::PARAM_INT);
            } else { // Post existant -> Update
                $query = $this->db->prepare(
                    "UPDATE myshop_forum_post 
                    SET content = :content, updated_at = NOW(), updated_by_id_member = :author
                    WHERE id_post = :id"
                );

                $query->bindValue(':content', $post->getContent(), \PDO::PARAM_STR);
                $query->bindValue(':author', $post->getUpdatedByIdMember(), \PDO::PARAM_INT);
                $query->bindValue(':id', $post->getId(), \PDO::PARAM_INT);
            }
            
            $query->execute();
        } catch (\PDOException $e) {
            echo '<pre>';
            print_r($this->db->errorInfo());
            print_r($e);
            echo '</pre>';
            exit;
        }
    }
    
    /**
     * Méthode qui renvoie un Post correspondant à un id donné
     *
     * @param $id
     *
     * @return mixed
     */
    public function getPostById($id)
    {
        $query = $this->db->prepare("SELECT * FROM myshop_forum_post WHERE id_post = :id_post");
        $query->execute(['id_post' => $id]);
    
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Forum\ForumPost');
        
        $post = $query->fetch();
        
        $manager = new MemberManager($this->db);
        $author = $manager->getMemberById($post->getCreatedByIdMember());
        
        $post->setAuthor($author);
        
        
        return $post;
    }
}
