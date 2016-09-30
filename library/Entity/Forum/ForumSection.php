<?php

namespace Entity\Forum;

use Core\ArrayCollection;
use Core\Entity;

/**
 * Class ForumSection
 * Représente une Rubrique (Section) du Forum, ses caractéristiques et une Collection de ses
 * discussions correspondantes
 *
 * Hérite d'Entity, une classe commune à toutes les entités de l'application
 */
class ForumSection extends Entity
{
    /*********************** PROPRIETES ***********************/

    private $id_section;
    private $id_category;
    private $name;
    private $description;
    private $slug;
    private $nb_posts;
    private $nb_threads;
    private $last_thread_id;

    private $threads;


    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->threads = new ArrayCollection();
    }


    /*********************** METHODES ***********************/

    /**
     * Indique si la section est nouvelle ou non, en vérifiant l'id.
     * S'il est défini, c'est une section existante, sinon, elle vient d'être crééé et n'existe pas en base
     *
     * @return bool Un booléen indiquant si la section est nouvelle ou pas
     */
    public function isNew()
    {
        return empty($this->id_section);
    }

    /**
     * Renvoie un tableau contenant toutes les discussions (Threads) de cette Section
     *
     * @return ArrayCollection L'ensemble des discussions
     */
    public function getThreads()
    {
        return $this->threads;
    }

    /**
     * Ajoute une Discussion à la Rubrique
     * La gestion de l'ajout est gérée à la classe ArraCollection
     *
     * @param ForumThread $thread Le Thread à ajouter à la Section
     *
     * @return $this Retourne l'instance de cette Section, permet un chaînage
     */
    public function addThread(ForumThread $thread)
    {
        $this->threads->addElement($thread);
    }

    /**
     * Supprime une Discussion de la Rubrique
     * La gestion de la suppression est gérée à la classe ArraCollection
     *
     * @param ForumThread $thread La discussion à supprimer à la section
     *
     * @return $this Retourne l'instance de cette section, permet un chaînage
     */
    public function removeThread(ForumThread $thread)
    {
        $this->threads->removeElement($thread);
    }


    /*********************** GETTERS ***********************/

    public function getId()
    {
        return $this->id_section;
    }

    public function getIdCategory()
    {
        return $this->id_category;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getNbPosts()
    {
        return $this->nb_posts;
    }

    public function getNbThreads()
    {
        return $this->nb_threads;
    }

    public function getLastThreadId()
    {
        return $this->last_thread_id;
    }


    /*********************** SETTERS ***********************/

    public function setId($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('L\'id de la section doit être un entier positif.');
        }
        $this->id_section = abs($id);
        
        return $this;
    }

    public function setIdCategory($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('L\'id de la catégorie doit être un entier positif.');
        }
        $this->id_category = abs($id);
        
        return $this;
    }

    public function setName($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('Le nom de la section doit être une chaîne de caractère.');
        }
        $this->name = $name;
        
        return $this;
    }

    public function setDescription($description)
    {
        if (!is_string($description)) {
            throw new \InvalidArgumentException('La description de la section doit être une chaîne de caractère.');
        }
        $this->description = $description;
        
        return $this;
    }

    public function setSlug($slug)
    {
        if (!is_string($slug)) {
            throw new \InvalidArgumentException('Le slug de la section doit être une chaîne de caractère.');
        }
        $this->slug = $slug;
        
        return $this;
    }

    public function setNbPosts($nb)
    {
        if (!is_int($nb)) {
            throw new \InvalidArgumentException('Le nombre de messages de la section doit être un entier positif.');
        }
        $this->nb_posts = abs($nb);
        
        return $this;
    }

    public function setNbThreads($nb)
    {
        if (!is_int($nb)) {
            throw new \InvalidArgumentException('Le nombre de discussion de la section doit être un entier positif.');
        }
        $this->nb_posts = abs($nb);
        
        return $this;
    }

    public function setLastThreadId($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('L\'id de la dernière discussion de la section doit être un entier positif.');
        }
        $this->last_thread_id = abs($id);
        
        return $this;
    }
}
