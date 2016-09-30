<?php
namespace Core;

/**
 * Class Entity
 * Modélise la base de toutes les entités de l'application
 *
 * @package Core
 */
abstract class Entity
{
    // Utilisation du trait Hydrator pour que les entités puissent être hydratées
    use Hydrator;
    
    
    /********************** CONSTRUCTEUR **********************/
    /**
     * Entity constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        // Si des données non nulles sont passées en paramètre, on hydrate l'objet
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }
    
    
    /********************** METHODES **********************/
    
    /**
     * Méthode qui vérifie si l'id est non null, ce qui signifie que l'entité n'est pas nouvelle
     * Permet de savoir si on doit faire une UPDATE ou INSERT par exemple
     */
    abstract public function isNew();
    
    
    /********************** GETTERS **********************/
    
    abstract public function getId();
    
    
    /********************** SETTERS **********************/
}
