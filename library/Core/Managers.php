<?php
namespace Core;

/**
 * Class Managers
 * Classe qui permet de gérer tous les managers
 * Possède une instance de la connexion à la base de donnée
 *
 * @package Core
 */
class Managers
{
    /********************** PROPRIETES **********************/
    
    protected $db = null;
    protected $managers = [];
    
    
    /********************** CONSTRUCTEUR **********************/
    /**
     * Managers constructor.
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    
    /********************** METHODES **********************/
    
    /**
     * Renvoie l'instance du manager du module passé en paramètre
     *
     * @param $module Le module dont on veut récupérer le manager
     * @throws \InvalidArgumentException L'exception levée si le module n'existe pas
     *
     * @return mixed Le manager correspondant au module
     */
    public function getManagerOf($module)
    {
        // Gestion du cas où le module n'est pas correct
        if (!is_string($module) || empty($module)) {
            throw new \InvalidArgumentException('Le module spécifié est invalide');
        }
        
        // Si le manager n'existe pas déjà, on l'instancie
        if (!isset($this->managers[$module])) {
            $manager = '\\Model\\'.$module.'Manager';
            $this->managers[$module] = new $manager($this->db);
        }
        
        return $this->managers[$module];
    }
}
