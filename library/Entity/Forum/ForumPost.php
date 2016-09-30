<?php

namespace Entity\Forum;

use Core\Entity;

/**
 * Class ForumPost
 * Représente un Message (Post) du Forum et ses caractéristiques
 *
 * Hérite d'Entity, une classe commune à toutes les entités de l'application
 */
class ForumPost extends Entity
{
    /*********************** PROPRIETES ***********************/

    private $id_post;
    private $content;
    private $created_at;
    private $updated_at;
    private $created_by_id_member;
    private $updated_by_id_member;
    private $id_thread;
    
    private $author;
    private $moderator;


    /*********************** METHODES ***********************/

    /**
     * Indique si le message (post) est nouveau ou non, en vérifiant l'id.
     * S'il est défini, c'est un message existant, sinon, il vient d'être créé et n'existe pas
     * en base
     *
     * @return bool Un booléen indiquant si le message est nouveau ou non
     */
    public function isNew()
    {
        return empty($this->id_post);
    }
    


    /*********************** GETTERS ***********************/

    public function getId()
    {
        return $this->id_post;
    }

    public function getContent()
    {
        return $this->content;
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
    
    public function getIdThread()
    {
        return $this->id_thread;
    }
    
    
    public function getAuthor()
    {
        return $this->author;
    }
    
    public function getModerator()
    {
        return $this->moderator;
    }


    /*********************** SETTERS ***********************/

    public function setId($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('L\'id du message doit être un entier positif.');
        }
        $this->id_post = abs($id);
    
        return $this;
    }

    public function setContent($content)
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('Le contenu du message doit être une chaîne de caractère.');
        }
        $this->content = $content;
    
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
            throw new \InvalidArgumentException('L\'id de l\'auteur du message doit être un entier positif.');
        }
        $this->created_by_id_member = abs($id);
    
        return $this;
    }
    
    public function setUpdatedByIdMember($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('L\'id du membre qui a édité le message doit être un entier positif.');
        }
        $this->updated_by_id_member = abs($id);
        
        return $this;
    }
    
    public function setIdThread($id)
    {
        if (!is_int((int) $id)) {
            throw new \InvalidArgumentException('L\'id du Thread du Post doit être un entier positif.');
        }
        $this->id_thread = (int) $id;
    
        return $this;
    }
    
    
    public function setAuthor(\Entity\Member $member = null)
    {
        if ($this->author && $this->author !== $member) {
            throw new \RuntimeException('Un autre membre est déjà affecté à ce post en tant qu\'auteur.');
        }
        $this->author = $member;
        
        return $this;
    }
    
    public function setModerator(\Entity\Member $member = null)
    {
        $this->moderator = $member;
        
        return $this;
    }
}
