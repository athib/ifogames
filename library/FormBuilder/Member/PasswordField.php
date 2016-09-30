<?php
namespace FormBuilder\Member;

use FormBuilder\Field;

/**
 * Class PasswordField
 * Modélisation d'un champ de type "Password" du formulaire, avec sa méthode d'affichage
 *
 * @package Core\FormBuilder
 */
class PasswordField extends Field
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
        
        $widget .= '<label>'.$this->getLabel().'</label><input type="password" name="'.$this->getName().'" placeholder="'.$this->getLabel().'"';
        
        
        // Ceci est un champ password, on ne réaffiche jamais la valeur saisie, par précaution
        
        // On définit la longueur max de saisie du champ
        if (!empty($this->maxLength)) {
            $widget .= ' maxlength="' . $this->maxLength . '"';
        }
        
        
        return $widget .= ' />';
    }
    
    
    /***********************  SETTERS  ***********************/
    
    public function setMaxLength($maxLength)
    {
        if (!is_int($maxLength) || $maxLength <= 0) {
            throw new \RuntimeException('La longueur maximale d\'un champ password doit être un nombre entier supérieur à 0.');
        }
        
        $this->maxLength = $maxLength;
    }
}
