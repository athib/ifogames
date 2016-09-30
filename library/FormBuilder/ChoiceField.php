<?php

namespace FormBuilder;

/**
 * Class ChoiceField
 * Modélisation d'un champ de type "Select" du formulaire, avec sa méthode d'affichage
 *
 * @package Core\FormBuilder
 */
class ChoiceField extends Field
{
    protected $multiple = false;
    protected $options = array();
    protected $optionsSelected = array();

    /**
     * Méthode de génération de l'affichage du champ textarea
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
        
        // label
        $widget .= '<label for="'.$this->getName().'">'.$this->getLabel().'</label>';
    
        $multiple = '';
        if (true === $this->multiple) {
            $multiple = 'multiple';
        }
        
        //select
        $widget .= '<select name="'.$this->getName().'"'.$multiple.'>';
        $widget .= '<option value="0" disabled '.(!$this->optionsSelected ? 'selected="selected"' : '').'>'.$this->getLabel().'</option>';
        foreach ($this->options as $value => $placeholder) {
            $selected = '';
            if (($this->optionsSelected && array_key_exists($value, $this->optionsSelected))) {
                $selected = 'selected="selected"';
            }
            $widget .= '<option value="'.$value.'" '.$selected.'>'.$placeholder.'</option>';
        }
        $widget .='</select>';
        
        
        return $widget;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function setOptionsSelected(array $options)
    {
        $this->optionsSelected = $options;
    }
    
    public function setMultiple($bool)
    {
        $this->multiple = $bool;
    }
}
