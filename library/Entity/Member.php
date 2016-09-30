<?php

namespace Entity;

use Core\ArrayCollection;
use Core\Entity;

/**
 * Class Member
 * Représente un Membre du site, et ses caractéristiques
 *
 * Hérite d'Entity, une classe commune à toutes les entités de l'application
 */
class Member extends Entity
{
    /*********************** PROPRIETES ***********************/
    
    private $id_member;
    private $username;
    private $password;
    private $passwordConfirm;
    private $email;
    private $firstname;
    private $lastname;
    private $gender;
    private $phone;
    private $role;
    private $last_login;
    private $created_at;
    private $newsletter;
    private $id_billing_address;
    private $id_mailing_address;
    
    private $billingAddress;
    private $mailingAddress;
    private $orders;
    
    
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->orders = new ArrayCollection();
    }

    
    /*********************** METHODES ***********************/
    
    /**
     * Méthode indiquant si un membre est authentifié ou non.
     * Lors d'une connexion valide, on déclare à TRUE une variable de session
     *
     * @return bool Un booléen indiquant si le membre est authentifié (true) ou non (false)
     */
    public function isAuthenticated()
    {
        return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
    }
    
    /**
     * Méthode permettant de mettre à jour le statut d'authentification d'un membre sur le site
     *
     * @param bool $authenticated Le booléen définissant le nouvel état de l'authentification
     * @throws \InvalidArgumentException Exception levée si l'état passé en paramètre n'est pas un booléen
     *
     * @return mixed
     */
    public function setAuthenticated($authenticated = true)
    {
        if (!is_bool($authenticated)) {
            throw new \InvalidArgumentException('La valeur spécifiée à la méthode Member::setAuthenticated() doit être un boolean');
        }
        $_SESSION['auth'] = $authenticated;
        
        return $this;
    }
    
    /**
     * Méthode indiquant si le Membre (authentifié ou non) a un message flash en attente
     *
     * @return bool Un booléen indiquant l'existence ou non d'un message flash pour le membre
     */
    public function hasFlash()
    {
        return isset($_SESSION['flash']);
    }
    
    /**
     * Méthode qui renvoie le message flash, et vide la session de ses messages
     *
     * @return mixed Le message flash à afficher au membre
     */
    public function getFlash()
    {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        
        return $flash;
    }
    
    /**
     * Méthode permettant de définir un message flash à afficher au membre
     *
     * @param $value Le contenu du message flash
     */
    public function setFlash($value)
    {
        $_SESSION['flash'] = $value;
    }
    
    /**
     * Indique si le membre est nouveau (nouveau ou anonyme) ou non, en vérifiant l'id.
     * S'il est défini, c'est un membre existant, sinon, il vient d'être créé ou n'est pas connecté
     *
     * @return bool Un booléen indiquant si le member est nouveau ou pas
     */
    public function isNew()
    {
        return empty($this->id_member);
    }
    
    /**
     * Méthode qui vérifie si le Membre est doté de certains droits
     *
     * @param $role Le rôle à vérifier pour le Membre
     * @return bool TRUE si le membre possède le role, FALSE sinon
     */
    public function isGranted($role)
    {
        return $this->getRole() === $role;
    }
    
    
    /*********************** GETTERS ***********************/
    
    public function getId()
    {
        return $this->id_member;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    public function getLastname()
    {
        return $this->lastname;
    }
    
    public function getGender()
    {
        return $this->gender;
    }
    
    public function getPhone()
    {
        return $this->phone;
    }
    
    public function getRole()
    {
        return $this->role;
    }
    
    public function getLastLogin()
    {
        return $this->last_login;
    }
    
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    public function getNewsletter()
    {
        return $this->newsletter;
    }
    
    public function getIdBillingAddress()
    {
        return $this->id_billing_address;
    }
    
    public function getIdMailingAddress()
    {
        return $this->id_mailing_address;
    }
    
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }
    
    public function getMailingAddress()
    {
        return $this->mailingAddress;
    }

    public function getOrders()
    {
        return $this->orders;
    }
    
    
    /*********************** SETTERS ***********************/

    public function setId($id)
    {
        $this->id_member = $id;
    }
    
    public function setUsername($username)
    {
        $this->username = $username;
        
        return $this;
    }
    
    public function setPassword($password)
    {
        $this->password = $password;
        
        return $this;
    }
    
    public function setPasswordConfirm($passwordConfirm)
    {
        $this->passwordConfirm = $passwordConfirm;
        
        return $this;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
        
        return $this;
    }
    
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        
        return $this;
    }
    
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        
        return $this;
    }
    
    public function setGender($gender)
    {
        $this->gender = $gender;
        
        return $this;
    }
    
    public function setPhone($phone)
    {
        $this->phone = $phone;
        
        return $this;
    }
    
    public function setRole($role)
    {
        $this->role = $role;
        
        return $this;
    }
    
    public function setLastLogin($last_login)
    {
        $this->last_login = $last_login;
        
        return $this;
    }
    
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        
        return $this;
    }
    
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;
        
        return $this;
    }
    
    public function setIdBillingAddress($id)
    {
        $this->id_billing_address = $id;
        
        return $this;
    }
    
    public function setIdMailingAddress($id)
    {
        $this->id_mailing_address = $id;
        
        return $this;
    }
    
    public function setBillingAddress(Address $address = null)
    {
        $this->billingAddress = $address;
        
        return $this;
    }
    
    public function setMailingAddress(Address $address = null)
    {
        $this->mailingAddress = $address;
        
        return $this;
    }
    
    public function setOrders($orders)
    {
        $this->orders = $orders;
        
        return $this;
    }
}
