<?php

namespace Entity\Shop;

use Core\Entity;

/**
 * Class Editor
 * Représente un Genre, et ses caractéristiques
 *
 * Hérite d'Entity, une classe commune à toutes les entités de l'application
 */
class Genre extends Entity
{
    /*********************** PROPRIETES ***********************/

    private $id_genre;
    private $name;


    /*********************** METHODES ***********************/
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
    
    public function isNew()
    {
        return empty($this->id_genre);
    }

    /*********************** GETTERS ***********************/
    
    public function getId()
    {
        return $this->id_genre;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    /*********************** SETTERS ***********************/
    
    public function setId($id_genre)
    {
        $this->id_genre = $id_genre;
        
        return $this;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
}
