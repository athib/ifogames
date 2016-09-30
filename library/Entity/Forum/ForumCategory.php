<?php

namespace Entity\Forum;

use Core\ArrayCollection;
use Core\Entity;

/**
 * Class ForumCategory
 * Représente une Catégorie du Forum, ses caractéristiques et une Collection de ses rubriques correspondantes
 *
 * Hérite d'Entity, une classe commune à toutes les entités de l'application
 */
class ForumCategory extends Entity
{
    /*********************** PROPRIETES ***********************/
    
    private $id_category;
    private $name;
    private $slug;
    private $position_weight;
    
    private $sections;
    
    
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->sections = new ArrayCollection();
    }
    
    
    /*********************** METHODES ***********************/
    
    /**
     * Indique si la catégorie est nouvelle ou non, en vérifiant l'id.
     * S'il est défini, c'est une catégorie existante, sinon, elle vient d'être crééé et n'existe pas en base
     *
     * @return bool Un booléen indiquant si la catégorie est nouvelle ou pas
     */
    public function isNew()
    {
        return empty($this->id_category);
    }
    
    /**
     * Renvoie un tableau contenant toutes les rubrique de cette Catégorie
     *
     * @return ArrayCollection L'ensemble des rubriques
     */
    public function getSections()
    {
        return $this->sections;
    }
    
    /**
     * Ajoute une Section à la Catégorie
     * La gestion de l'ajout est gérée à la classe ArraCollection
     *
     * @param ForumSection $section La Section à ajouter à la Catégorie
     *
     * @return $this Retourne l'instance de cette catégorie, permet un chaînage
     */
    public function addSection(\Entity\Forum\ForumSection $section)
    {
        $this->sections->addElement($section);
        
        return $this;
    }
    
    /**
     * Supprime une Section de la Catégorie
     * La gestion de la suppression est gérée à la classe ArraCollection
     *
     * @param ForumSection $section La Section à supprimer à la Catégorie
     *
     * @return $this Retourne l'instance de cette catégorie, permet un chaînage
     */
    public function removeSection(\Entity\ForumSection $section)
    {
        $this->sections->removeElement($section);
        
        return $this;
    }
    
    
    /*********************** GETTERS ***********************/
    
    public function getId()
    {
        return $this->id_category;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function getPositionWeight()
    {
        return $this->position_weight;
    }
    
    
    /*********************** SETTERS ***********************/
    
    public function setId($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('L\'id de la catégorie doit être un entier positif.');
        }
        $this->id_category = abs($id);
    }
    
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('Le nom de la catégorie doit être une chaîne de caractère.');
        }
        $this->name = $name;
    }
    
    public function setSlug($slug)
    {
        if (!is_string($slug)) {
            throw new \InvalidArgumentException('Le slug de la catégorie doit être une chaîne de caractère.');
        }
        $this->slug = $slug;
    }
    
    public function setPositionWeight($weight)
    {
        if (!is_int($weight)) {
            throw new \InvalidArgumentException('Le poids de la catégorie doit être un entier positif.');
        }
        $this->weight = abs($weight);
    }
}
