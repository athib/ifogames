<?php

namespace Entity\Shop;

use Core\Entity;

/**
 * Class Editor
 * Représente un Editeur, et ses caractéristiques
 *
 * Hérite d'Entity, une classe commune à toutes les entités de l'application
 */
class Editor extends Entity
{
    /*********************** PROPRIETES ***********************/

    private $id_editor;
    private $name;
    private $country;
    private $year;


    /*********************** METHODES ***********************/

    /**
     * Indique si un éditeur est nouveau ou non, en vérifiant l'id.
     * S'il est défini, c'est un éditeur existant, sinon, il vient d'être créé
     *
     * @return bool Un booléen indiquant si l'éditeur est nouveau ou pas
     */
    public function isNew()
    {
        return empty($this->id_editor);
    }

    /*********************** GETTERS ***********************/
    
    public function getId()
    {
        return $this->id_editor;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getCountry()
    {
        return $this->country;
    }
    
    public function getYear()
    {
        return $this->year;
    }
    

    /*********************** SETTERS ***********************/
    
    public function setId($id_editor)
    {
        $this->id_editor = $id_editor;
        
        return $this;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function setCountry($country)
    {
        $this->country = $country;
        
        return $this;
    }
    
    public function setYear($year)
    {
        $this->year = $year;
        
        return $this;
    }
}
