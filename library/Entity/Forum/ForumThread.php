<?php

namespace Entity\Forum;

use Core\ArrayCollection;
use Core\Entity;
use Entity\Member;

/**
 * Class ForumThread
 * Représente une Discussion (Thread) du Forum, ses caractéristiques et une Collection de ses
 * messages (posts) correspondants
 *
 * Hérite d'Entity, une classe commune à toutes les entités de l'application
 */
class ForumThread extends Entity
{
    /*********************** PROPRIETES ***********************/
    
    private $id_thread;
    private $id_section;
    private $topic;
    private $slug;
    private $nb_posts;
    private $created_at;
    private $updated_at;
    private $created_by_id_member;
    private $updated_by_id_member;
    private $last_post_id;
    
    private $posts;
    private $author;
    private $moderator;
    private $section;
    
    
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        
        $this->posts = new ArrayCollection();
    }
    
    
    /*********************** METHODES ***********************/
    
    /**
     * Indique si la discussion (thread) est nouvelle ou non, en vérifiant l'id.
     * S'il est défini, c'est une discussion existante, sinon, elle vient d'être crééé et n'existe pas en base
     *
     * @return bool Un booléen indiquant si la discussion est nouvelle ou pas
     */
    public function isNew()
    {
        return empty($this->id_thread);
    }
    
    /**
     * Renvoie un tableau contenant tous les messages (posts) de cette discussion
     *
     * @return ArrayCollection L'ensemble des posts
     */
    public function getPosts()
    {
        return $this->posts;
    }
    
    /**
     * Ajoute un Post au Thread
     * La gestion de l'ajout est gérée à la classe ArraCollection
     *
     * @param ForumPost $post Le Post à ajouter au Thread
     *
     * @return $this Retourne l'instance de ce Thread, permet un chaînage
     */
    public function addPost(ForumPost $post)
    {
        $this->posts->addElement($post);
    }
    
    /**
     * Supprime un Post de ce Thread
     * La gestion de la suppression est gérée à la classe ArraCollection
     *
     * @param ForumPost $post Le Post à supprimer du Thread
     *
     * @return $this Retourne l'instance de ce Thread, permet un chaînage
     */
    public function removePost(ForumPost $post)
    {
        $this->posts->removeElement($post);
    }
    
    
    /*********************** GETTERS ***********************/
    
    public function getId()
    {
        return $this->id_thread;
    }
    
    public function getIdSection()
    {
        return $this->id_section;
    }
    
    public function getTopic()
    {
        return $this->topic;
    }
    
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function getNbPosts()
    {
        return $this->nb_posts;
    }
    
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    
    public function getCreatedByIdMember()
    {
        return $this->created_by_id_member;
    }
    
    public function getUpdatedByIdMember()
    {
        return $this->updated_by_id_member;
    }
    
    public function getLastPostId()
    {
        return $this->last_post_id;
    }
    
    
    public function getAuthor()
    {
        return $this->author;
    }
    
    public function getModerator()
    {
        return $this->moderator;
    }
    
    public function getSection()
    {
        return $this->section;
    }
    
    
    /*********************** SETTERS ***********************/
    
    public function setId($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('L\'id de la discussion doit être un entier positif.');
        }
        $this->id_thread = abs($id);
        
        return $this;
    }
    
    public function setIdSection($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('L\'id de la rubrique de la discussion doit être un entier positif.');
        }
        $this->id_category = abs($id);
    
        return $this;
    }
    
    public function setTopic($topic)
    {
        if (!is_string($topic)) {
            throw new \InvalidArgumentException('Le sujet de la discussion doit être une chaîne de caractère.');
        }
        $this->topic = $topic;
    
        return $this;
    }
    
    public function setSlug($slug)
    {
        if (!is_string($slug)) {
            throw new \InvalidArgumentException('Le slug de la discussion doit être une chaîne de caractère.');
        }
        $this->slug = $slug;
        
        return $this;
    }
    
    public function setNbPosts($nb)
    {
        if (!is_int($nb)) {
            throw new \InvalidArgumentException('Le nombre de messages de la discussion doit être un entier positif.');
        }
        $this->nb_posts = abs($nb);
        
        return $this;
    }
    
    public function setCreatedAt(\DateTime $date)
    {
        $this->created_at = $date;
        
        return $this;
    }
    
    public function setUpdatedAt(\DateTime $date)
    {
        $this->updated_at = $date;
        
        return $this;
    }
    
    public function setCreatedByIdMember($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('L\'id de l\'auteur de la discussion doit être un entier positif.');
        }
        $this->created_by_id_member = abs($id);
        
        return $this;
    }
    
    public function setUpdatedByIdMember($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('L\'id du membre qui a édité la discussion doit être un entier positif.');
        }
        $this->updated_by_id_member = abs($id);
        
        return $this;
    }
    
    public function setLastPostId($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('L\'id du dernier message de la discussion doit être un entier positif.');
        }
        $this->last_post_id = abs($id);
    
        return $this;
    }
    
    
    public function setAuthor(\Entity\Member $member)
    {
        if ($this->author && $this->author !== $member) {
            throw new \RuntimeException('Un autre membre est déjà affecté à cette discussion en tant qu\'auteur.');
        }
        $this->author = $member;
        
        return $this;
    }
    
    public function setModerator(Member $member)
    {
        $this->moderator = $member;
        
        return $this;
    }
    
    public function setSection(ForumSection $section)
    {
        $this->section = $section;
        
        return $this;
    }
}
