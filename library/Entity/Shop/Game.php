<?php

namespace Entity\Shop;

use Core\ArrayCollection;
use Core\Entity;

/**
 * Class Game
 * Représente un Jeu du site, et ses caractéristiques
 *
 * Hérite d'Entity, une classe commune à toutes les entités de l'application
 */
class Game extends Entity
{
    public static $availablePegi = ['all', '3', '7', '12', '16', '18'];
    

    /*********************** PROPRIETES ***********************/

    private $id_game;
    private $title;
    private $slug;
    private $description;
    private $id_editor;
    private $release_date;
    private $price;
    private $pegi;
    private $pre_order;
    private $jacket;
    
    private $editor;
    private $genres;
    private $platforms;
    
    private $orderedPlatform;
    
    
    
    /*********************** METHODES ***********************/
    
    /**
     * Indique si le jeu est nouveau ou non, en vérifiant l'id.
     * S'il est défini, c'est un jeu existant, sinon, il vient d'être créé
     *
     * @return bool Un booléen indiquant si le jeu est nouveau ou pas
     */
    public function isNew()
    {
        return empty($this->id_game);
    }
    
    /*********************** GETTERS ***********************/
    
    public function getId()
    {
        return $this->id_game;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getIdEditor()
    {
        return $this->id_editor;
    }
    
    public function getReleaseDate()
    {
        /*if (!$this->release_date instanceof \DateTime) {
            $this->release_date = new \DateTime($this->release_date);
        }*/
        
        return $this->release_date;
    }
    
    public function getPrice()
    {
        return $this->price;
    }
    
    public function getPegi()
    {
        return $this->pegi;
    }
    
    public function getPreOrder()
    {
        return $this->pre_order;
    }
    
    public function getJacket()
    {
        return $this->jacket;
    }
    
    public function getEditor()
    {
        return $this->editor;
    }
    
    public function getGenres()
    {
        return $this->genres;
    }
    
    public function getPlatforms()
    {
        return $this->platforms;
    }
    
    public function getOrderedPlatform()
    {
        return $this->orderedPlatform;
    }
    
    
    /*********************** SETTERS ***********************/
    
    public function setId($id)
    {
        $this->id_game = $id;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }
    
    public function setSlug($slug)
    {
        $this->slug = $slug;
        
        return $this;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
        
        return $this;
    }
    
    public function setIdEditor($id_editor)
    {
        $this->id_editor = $id_editor;
        
        return $this;
    }
    
    public function setReleaseDate($release_date)
    {
        $this->release_date = $release_date;
        
        return $this;
    }
    
    public function setPrice($price)
    {
        $this->price = $price;
        
        return $this;
    }
    
    public function setPegi($pegi)
    {
        if (!in_array($pegi, self::$availablePegi, true)) {
            //throw new \InvalidArgumentException('La valeur '.$pegi.'n\'est pas valide pour le champ "PEGI".');
        }
        
        $this->pegi = $pegi;
        
        return $this;
    }
    
    public function setPreOrder($pre_order)
    {
        $this->pre_order = $pre_order;
        
        return $this;
    }
    
    public function setJacket($jacket)
    {
        $this->jacket = $jacket;
        
        return $this;
    }
    
    public function setEditor(Editor $editor)
    {
        $this->editor = $editor;
        
        return $this;
    }
    
    public function setGenres(array $genres)
    {
        $this->genres = new ArrayCollection($genres);
        
        return $this;
    }
    
    public function setPlatforms(array $platforms)
    {
        $this->platforms = new ArrayCollection($platforms);
        
        return $this;
    }
    
    public function setOrderedPlatform(Platform $platforms)
    {
        $this->orderedPlatform = $platforms;
        
        return $this;
    }
}
