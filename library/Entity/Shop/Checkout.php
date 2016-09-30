<?php

namespace Entity\Shop;

use Core\Entity;

/**
 * Class Checkout
 * Représente les données d'utilisateur pour la validation du panier
 * @package Entity\Shop
 */
class Checkout extends Entity
{
    protected $id;
    protected $firstname;
    protected $lastname;
    protected $phone;
    protected $billingStreet;
    protected $billingCity;
    protected $billingPostalCode;
    protected $mailingStreet;
    protected $mailingCity;
    protected $mailingPostalCode;
    protected $email;
    protected $sameAsBilling;

    /**
     * Renvoie l'id de l'instance Checkout
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Renvoie TRUE si l'objet est nouveau (id null) FALSE sinon
     *
     * @return bool
     */
    public function isNew()
    {
        return empty($this->id);
    }


    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getBillingStreet()
    {
        return $this->billingStreet;
    }
    
    public function getBillingCity()
    {
        return $this->billingCity;
    }
    
    public function getBillingPostalCode()
    {
        return $this->billingPostalCode;
    }

    public function getMailingStreet()
    {
        return $this->mailingStreet;
    }
    
    public function getMailingCity()
    {
        return $this->mailingCity;
    }
    
    public function getMailingPostalCode()
    {
        return $this->mailingPostalCode;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getSameAsBilling()
    {
        return $this->sameAsBilling;
    }


    public function setFirstname($name)
    {
        $this->firstname = $name;
        
        return $this;
    }

    public function setLastname($name)
    {
        $this->lastname = $name;

        return $this;
    }

    public function setBillingStreet($street)
    {
        $this->billingStreet = $street;

        return $this;
    }

    public function setBillingCity($city)
    {
        $this->billingCity = $city;

        return $this;
    }

    public function setBillingPostalCode($postalCode)
    {
        $this->billingPostalCode = $postalCode;

        return $this;
    }

    public function setMailingStreet($street)
    {
        $this->mailingStreet = $street;

        return $this;
    }

    public function setMailingCity($city)
    {
        $this->mailingCity = $city;

        return $this;
    }

    public function setMailingPostalCode($postalCode)
    {
        $this->mailingPostalCode = $postalCode;

        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function setSameAsBilling($same)
    {
        $this->sameAsBilling = $same;

        return $this;
    }
}
