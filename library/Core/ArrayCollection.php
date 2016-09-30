<?php
namespace Core;

/**
 * Class ArrayCollection
 * Représente un ensemble d'objets contenus dans un tableau, amélioré par des méthodes
 *
 * @implements \Iterator Pour rendre possible un parcours avec foreach
 * @implements \Countable Pour pouvoir compter le nombre d'éléments de la collection
 */
class ArrayCollection implements \Iterator, \Countable
{
    private $elements;
    private $allowDuplicates;
    
    /**
     * ArrayCollection constructor.
     *
     * @param array $elements Un tableau d'éléments pour initialiser la collection
     */
    public function __construct(array $elements = array(), $allowDuplicates = false)
    {
        $this->elements = $elements;
        $this->allowDuplicates = $allowDuplicates;
    }
    
    /**
     * @return array Une représentation sous forme de tableau de la collection
     */
    public function toArray()
    {
        return $this->elements;
    }
    
    /**
     * Supprime l'élément de la collection à un indice spécifique
     *
     * @param $key L'indice de l'élément à supprimer
     *
     * @return mixed|null Renvoie l'élément supprimé, NULL si l'élément n'existe pas
     */
    public function remove($key)
    {
        if (isset($this->elements[$key])) {
            $removed = $this->elements[$key];
            unset($this->elements[$key]);
            
            return $removed;
        }
        
        return null;
    }
    
    /**
     * Supprime un élément de la collection, s'il existe.
     *
     * @param $element L'élément à supprimer
     *
     * @return bool Renvoie TRUE si l'élément a bien été supprimé, FALSE sinon
     */
    public function removeElement($element)
    {
        $key = array_search($element, $this->elements, false);
        if ($key !== false) {
            unset($this->elements[$key]);
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Ajoute un élément à la collection, s'il n'existe pas déjà.
     *
     * @param $element L'élément à ajouter
     *
     * @return bool Retourne TRUE si l'élément a bien été ajouté, FALSE sinon.
     */
    public function addElement($element)
    {
        if (!$this->allowDuplicates) {
            foreach ($this->elements as $e) {
                if ($e == $element) {
                    return false;
                }
            }
        }
    
        $this->elements[] = $element;
    
        return true;
    }
    
    
    /***** Implémentation des méthodes de l'interface ITERATOR *****/
    
    // Réinitialise le pointeur interne du tableau sur le premier élément
    public function rewind()
    {
        reset($this->elements);
    }
    
    // Renvoie la valeur de l'élément sur lequel le pointeur interne du tableau se trouve
    public function key()
    {
        return key($this->elements);
    }
    
    // Renvoie l'indice de l'élément sur lequel le pointeur interne du tableau se trouve
    public function next()
    {
        return next($this->elements);
    }
    
    // Renvoie l'élément suivant par rapport à la position courante du pointeur interne
    public function valid()
    {
        return $this->current() !== false;
    }
    
    // Indique si le pointeur interne du tableau désigne un élément ou null
    public function current()
    {
        return current($this->elements);
    }
    
    
    /***** Implémentation de la méthode de l'interface COUNTABLE *****/
    
    // Renvoie le nombre d'éléments de la collection
    public function count()
    {
        return count($this->elements);
    }
}
