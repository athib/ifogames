<?php

namespace Entity;

use Core\Entity;

class Address extends Entity
{
    protected $id_address;
    protected $title;
    protected $street;
    protected $postal_code;
    protected $city;
    
    
    public function __toString()
    {
        return $this->street.' '.$this->postal_code.' '.$this->city;
    }
    
    public function isNew()
    {
        return empty($this->id_address);
    }
    

    public function getId()
    {
        return $this->id_address;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function getStreet()
    {
        return $this->street;
    }
    
    public function getPostalCode()
    {
        return $this->postal_code;
    }
    
    public function getCity()
    {
        return $this->city;
    }


    public function setId($id)
    {
        $this->id_address = $id;
    }
    
    public function setStreet($street)
    {
        $this->street = $street;
        
        return $this;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }
    
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
    
        return $this;
    }
    
    public function setCity($city)
    {
        $this->city = $city;
        
        return $this;
    }
}
