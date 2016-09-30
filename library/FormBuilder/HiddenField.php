<?php
namespace FormBuilder;

/**
 * Class HiddenField
 * Modélisation d'un champ de type "Input hidden" du formulaire, avec sa méthode d'affichage
 *
 * @package Core\FormBuilder
 */
class HiddenField extends Field
{
    protected $maxLength;
    
    /**
     * Méthode de génération de l'affichage du champ hidden
     *
     * @return string
     */
    public function buildWidget()
    {
        $widget = '';
        $classes = ($this->getClasses()) ? ' class="'.implode(' ', $this->getClasses()).'"' : '';
        
        $widget .= '<input type="hidden" name="'.$this->getName().'"';
        
        // Si des classes sont définies
        if ($this->getClasses()) {
            //$widget .= ' class="'.implode(' ', $this->getClasses()).'"';
            $widget .= $classes;
        }
        
        // Si une valeur est définie on l'affiche
        if (!empty($this->value)) {
            $widget .= ' value="'.htmlspecialchars($this->getValue()).'"';
        }
        
        return $widget .= ' />';
    }
}
