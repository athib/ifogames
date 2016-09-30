<?php
namespace Core;

/**
 * Trait Hydrator
 * Implémente une méthode générique pour affecter des données à une entité
 * Déporter ce code dans un trait permet une réutilisation et par définition évite la duplication
 *
 * @package Core
 */
trait Hydrator
{
    public function hydrate($data)
    {
        // Pour chaque donnée on vérifie s'il existe un setter et on l'utilise
        foreach ($data as $key => $value) {
            $method = 'set' . implode('', array_map('ucfirst', explode('_', $key)));
            
            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }
    }
}
