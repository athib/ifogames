<?php

namespace FormBuilder;

/**
 * Class EmailField
 * Modélisation d'un champ de type "Email" du formulaire, avec sa méthode d'affichage
 *
 * @package Core\FormBuilder
 */
class EmailField extends Field
{
    protected $maxLength;


    /***********************  METHODES  ***********************/

    /**
     * Méthode de génération de l'affichage du champ
     *
     * @return string
     */
    public function buildWidget()
    {
        $widget = '';

        // S'il y a un message d'erreur, on l'affiche
        if (!empty($this->errorMessage)) {
            $widget .= '<span class="form-error">'.$this->errorMessage.'</span><br />';
        }

        $widget .= '<label>'.$this->getLabel().'</label><input type="email" name="'.$this->getName().'" placeholder="'.$this->getLabel().'"';

        // Si une valeur est définie on l'affiche
        if (!empty($this->value)) {
            $widget .= ' value="'.htmlspecialchars($this->value).'"';
        }

        // On définit la longueur max de saisie du champ
        if (!empty($this->maxLength)) {
            $widget .= ' maxlength="'.$this->maxLength.'"';
        }
        
        return $widget .= ' />';
    }


    /***********************  SETTERS  ***********************/

    public function setMaxLength($maxLength)
    {
        if (!is_int($maxLength) || $maxLength <= 0) {
            throw new \RuntimeException('La longueur maximale d\'un champ email doit être un nombre entier supérieur à 0.');
        }

        $this->maxLength = $maxLength;
    }
}
