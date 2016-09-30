<?php
namespace Core;

/**
 * Class Manager
 * Classe mère pour tous les managers
 * Possède une instance de la connexion à la base de données
 *
 * @package Core
 */
abstract class Manager
{
    protected $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
}
