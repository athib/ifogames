<?php
namespace FormBuilder;

/**
 * Class CheckboxField
 * Modélisation d'un champ de type "Input checkbox" du formulaire, avec sa méthode d'affichage
 *
 * @package Core\FormBuilder
 */
class CheckboxField extends Field
{
    protected $checked;


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

        $widget .= '<label for="'.$this->getName().'" class="force-display">'.$this->getLabel().'</label><input type="checkbox" name="'.$this->getName().'"';

        // Si des classes sont définies
        if ($this->getClasses()) {
            $widget .= ' class="'.implode(' ', $this->getClasses()).'"';
        }

        if ($this->checked) {
            $widget .= ' value="1" checked="checked"';
        } else {
            $widget .= ' value="0"';
        }

        return $widget .= ' />';
    }


    /***********************  GETTERS  ***********************/

    public function getChecked()
    {
        return $this->checked;
    }

    /***********************  SETTERS  ***********************/

    public function setChecked($checked)
    {
        if (!is_bool($checked)) {
            throw new \RuntimeException('La valeur "checked" d\'une Checkbox doit être un booléen');
        }
        $this->checked = $checked;

        return $this;
    }
}
