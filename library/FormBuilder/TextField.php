<?php
namespace FormBuilder;

/**
 * Class TextField
 * Modélisation d'un champ de type "Textarea" du formulaire, avec sa méthode d'affichage
 *
 * @package Core\FormBuilder
 */
class TextField extends Field
{
    protected $cols;
    protected $rows;


    /***********************  METHODES  ***********************/

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

        $widget .= '<label for="'.$this->getName().'">'.$this->getLabel().'</label><textarea name="'.$this->getName().'" placeholder="'.$this->getLabel().'"';

        // Si on a défini une largeur pour le champ
        if (!empty($this->cols)) {
            $widget .= ' cols="'.$this->cols.'"';
        }

        // idem, si on a défini une hauteur
        if (!empty($this->rows)) {
            $widget .= ' rows="'.$this->rows.'"';
        }

        $widget .= '>';

        // S'il y a une valeur définie
        if (!empty($this->value)) {
            $widget .= htmlspecialchars($this->value);
        }
        
        return $widget . '</textarea>';
    }


    /***********************  SETTERS  ***********************/

    public function setCols($cols)
    {
        $cols = (int)$cols;

        if ($cols > 0) {
            $this->cols = $cols;
        }
        
        return $this;
    }

    public function setRows($rows)
    {
        $rows = (int)$rows;

        if ($rows > 0) {
            $this->rows = $rows;
        }
        
        return $this;
    }
}
