<?php
namespace FormBuilder;

/**
 * Class FileField
 * Modélisation d'un champ de type "File" du formulaire, avec sa méthode d'affichage
 *
 * @package Core\FormBuilder
 */
class FileField extends Field
{
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

        $widget .= '<label for="'.$this->getName().'">'.$this->getLabel().'</label>';

        $widget .= '<input name="'.$this->getName().'" type="file" />';

        $widget .= '<div id="image_preview">
                        <div class="thumbnail hidden">
                            <img src="http://placehold.it/5" alt="">
                            <div class="caption">
                                <h4></h4>
                                <p></p>
                                <p><button type="button" class="btn btn-default btn-danger">Annuler</button></p>
                            </div>
                        </div>
                    </div>';


        return $widget;
    }
}
