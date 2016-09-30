<?php
namespace FormBuilder;

use Core\Application;
use Core\ApplicationComponent;
use Core\ArrayCollection;
use Core\Entity;

/**
 * Class Form
 * Classe modélisant un Formulaire correspondant à une entité.
 * Contient une liste de champs (Fields), une méthode de validatione une autre pour fabriquer une vue
 * utilisable pour l'affichage
 *
 * @package Core\FormBuilder
 */
class Form extends ApplicationComponent
{
    const FIELDSET_START = 'fieldsetStart';
    const FIELDSET_END = 'fieldsetEnd';
    
    // L'entité correspondante au formulaire
    protected $entity;

    // Les champs du formulaire
    protected $fields;

    /**
     * Form constructor.
     * On définit l'entité à laquelle est liée ce formulaire
     * @param Entity $entity
     */
    public function __construct(Entity $entity)
    {
        $this->fields = new ArrayCollection(array(), true);
        $this->setEntity($entity);
    }


    /***********************  METHODES  ***********************/

    /**
     * Méthode qui permet d'ajouter un champ Field à la liste des champs du formulaire
     * On définit une valeur via une méthode de l'entité
     *
     * @param Field $field Le champ à ajouter à la liste
     *
     * @return $this Renvoie l'instance du formulaire, permet un chaînage
     */
    public function add(Field $field)
    {
        // On récupère le nom du champ.
        $attr   = $field->getName();

        // On définit le getter
        $getter = 'get'.ucfirst($attr);

        // On assigne la valeur correspondante au champ.
        $field->setValue($this->entity->$getter());

        if ($field instanceof CheckboxField) {
            if ($this->entity->$getter() == 1) {
                $field->setChecked(true);
            } else {
                $field->setChecked(false);
            }
        }

        // On ajoute le champ passé en argument à la liste des champs.
        $this->fields->addElement($field);

        return $this;
    }

    /**
     * Méthode de génération de la vue du formulaire
     * Fait appel à la méthode de génération de vue de chaque champ (voir buildWidget)
     *
     * @return string Une chaîne de caractère représentant la vue du formulaire
     */
    public function createView()
    {
        $view = '';

        foreach ($this->fields as $field) {
            if (is_array($field) and isset($field[self::FIELDSET_START])) {
                $view .= '<fieldset>';
                $view .= '<legend>'.$field[self::FIELDSET_START].'</legend>';
            } elseif (is_array($field) and isset($field[self::FIELDSET_END])) {
                $view .= '</fieldset>';
            } else {
                $view .= $field->buildWidget().'<br />';
            }
        }
        
        return $view;
    }

    /**
     * Méthode de validation du formulaire
     * Fait appel à la méthode de validation de chaque champ
     *
     * @return bool Un booléen qui indique si le formulaire est valide ou non
     */
    public function isValid()
    {
        $valid = true;

        // On vérifie que tous les champs sont valides.
        foreach ($this->fields as $field) {
            if ($field instanceof Field && !$field->isValid()) {
                $valid = false;
            }
        }

        return $valid;
    }
    
    
    public function startFieldset($legend = '')
    {
        $this->fields->addElement(array('fieldsetStart' => $legend));
        
        return $this;
    }
    
    public function endFieldset()
    {
        $this->fields->addElement(array('fieldsetEnd' => ''));

        return $this;
    }



    /***********************  GETTERS  ***********************/

    public function getEntity()
    {
        return $this->entity;
    }


    /***********************  SETTERS  ***********************/

    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;

        return $this;
    }
}
