<?php
namespace FormBuilder;

/**
 * Class StringField
 * Modélisation d'un champ de type "Input text" du formulaire, avec sa méthode d'affichage
 *
 * @package Core\FormBuilder
 */
class StringField extends Field
{
    protected $maxLength;
    
    
    /***********************  METHODES  ***********************/
    
    /**
     * Méthode de génération de l'affichage du champ textarea
     *
     * @return string
     */
    public function buildWidget()
    {
        $widget = '';
        $classes = ($this->getClasses()) ? ' class="'.implode(' ', $this->getClasses()).'"' : '';
    
        // S'il y a un message d'erreur, on l'affiche
        if (!empty($this->errorMessage)) {
            $widget .= '<span class="form-error">'.$this->errorMessage.'</span><br />';
        }
        
        $widget .= '<label for="'.$this->getName().'"'.$classes.'>'.$this->getLabel().'</label><input type="text" name="'.$this->getName().'" placeholder="'.$this->getLabel().'"';
        
        // Si des classes sont définies
        if ($this->getClasses()) {
            //$widget .= ' class="'.implode(' ', $this->getClasses()).'"';
            $widget .= $classes;
        }
        
        // Si une valeur est définie on l'affiche
        if (!empty($this->value)) {
            $widget .= ' value="'.htmlspecialchars($this->getValue()).'"';
        }
        
        // On définit la longueur max de saisie du champ
        if (!empty($this->maxLength)) {
            $widget .= ' maxlength="'.$this->getMaxLength().'"';
        }
        
        return $widget .= ' />';
    }
    
    
    /***********************  GETTERS  ***********************/
    
    public function getMaxLength()
    {
        return $this->maxLength;
    }
    
    /***********************  SETTERS  ***********************/
    
    public function setMaxLength($maxLength)
    {
        if (!is_int($maxLength) || $maxLength <= 0) {
            throw new \RuntimeException('La longueur maximale d\'un champ texte doit être un nombre entier supérieur à 0.');
        }
        $this->maxLength = $maxLength;
        
        return $this;
    }
}
