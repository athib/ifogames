<?php

namespace Entity\Shop;

use Core\Entity;

/**
 * Class Platform
 * Représente une Plateforme, et ses caractéristiques
 *
 * Hérite d'Entity, une classe commune à toutes les entités de l'application
 */
class Platform extends Entity
{
    /*********************** PROPRIETES ***********************/

    private $id_platform;
    private $short_name;
    private $full_name;
    private $owner;
    private $release_date;


    /*********************** METHODES ***********************/
    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->getFullName();
    }
    
    public function isNew()
    {
        return empty($this->id_platform);
    }

    /*********************** GETTERS ***********************/
    
    public function getId()
    {
        return $this->id_platform;
    }
    
    public function getShortName()
    {
        return $this->short_name;
    }
    
    public function getFullName()
    {
        return $this->full_name;
    }
    
    public function getOwner()
    {
        return $this->owner;
    }
    
    public function getReleaseDate()
    {
        return $this->release_date;
    }
    
    /*********************** SETTERS ***********************/
    
    public function setId($id)
    {
        $this->id_platform = $id;
        
        return $this;
    }
    
    public function setShortName($name)
    {
        $this->short_name = $name;
        
        return $this;
    }
    
    public function setFullName($name)
    {
        $this->full_name = $name;
        
        return $this;
    }
    
    public function setOwner($owner)
    {
        $this->owner = $owner;
        
        return $this;
    }
    
    public function setReleaseDate(\DateTime $date)
    {
        $this->release_date = $date;
        
        return $this;
    }
}
