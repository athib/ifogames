<?php
namespace FormBuilder;

use Core\ArrayCollection;
use Core\Hydrator;
use FormBuilder\Validator\Validator;

/**
 * Class Field
 * Classe permettant de modéliser le champ d'un formulaire.
 * C'est une classe de base (abstraite), qui sera héritée puis surchargée pour les besoins
 * sépcifiques de chaque champ
 *
 * @package Core\FormBuilder
 */
abstract class Field
{
    // Utilisation du Trait Hydrator
    use Hydrator;


    /***********************  PROPRIETES  ***********************/

    protected $errorMessage;
    protected $validators;
    
    protected $attributes;
    
    protected $label;
    protected $name;
    protected $value;
    protected $placeholder;
    protected $id;
    protected $classes;


    /***********************  CONSTRUCTEUR  ***********************/

    public function __construct(array $options = [])
    {
        $this->validators = new ArrayCollection();
        $this->attributes = array();

        if (!empty($options)) {
            $this->hydrate($options);
        }
    }


    /***********************  METHODES  ***********************/

    /**
     * Méthode à redéfinir pour chaque champ, afin de générer une vue spécifique
     *
     * @return mixed
     */
    abstract public function buildWidget();

    /**
     * Méthode qui permet de vérifier l'intégrité des informations d'un champ
     *
     * @return bool Un booléen indiquant si le champ est valide ou non
     */
    public function isValid()
    {
        // On parcourt tous les validateurs du champ et on vérifie qui sa valeur est conforme
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($this->value)) {
                $this->errorMessage = $validator->getErrorMessage();

                return false;
            }
        }

        return true;
    }
    
    protected function buildAttributes()
    {
        $var = '';
        
        foreach ($this->getAttributes() as $attr => $value) {
            $var .= "$attr=\"$value\"";
        }
        
        return $var;
    }



    /***********************  GETTERS  ***********************/

    public function getId()
    {
        return $this->id;
    }
    
    public function getClasses()
    {
        return $this->classes;
    }
    
    public function getLabel()
    {
        return $this->label;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValidators()
    {
        return $this->validators;
    }

    public function getValue()
    {
        return $this->value;
    }
    
    public function getPlaceholder()
    {
        return $this->placeholder;
    }
    
    public function getAttributes()
    {
        return $this->attributes;
    }



    /***********************  SETTERS  ***********************/
    
    public function setId($id)
    {
        $id = (int)$id;
        
        if ($id > 0) {
            $this->id = $id;
        }
        
        return $this;
    }
    
    public function setClasses(array $classes)
    {
        $this->classes = $classes;
    }
    
    public function setLabel($label)
    {
        if (is_string($label)) {
            $this->label = $label;
        }

        return $this;
    }

    public function setLength($length)
    {
        $length = (int)$length;

        if ($length > 0) {
            $this->length = $length;
        }

        return $this;
    }

    public function setName($name)
    {
        if (is_string($name)) {
            $this->name = $name;
        }

        return $this;
    }
    
    public function setPlaceholder($placeholder)
    {
        if (is_string($placeholder)) {
            $this->placeholder = $placeholder;
        }
        
        return $this;
    }

    public function setValidators(array $validators)
    {
        foreach ($validators as $validator) {
            if ($validator instanceof Validator) {
                $this->validators->addElement($validator);
            }
        }

        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
    
    public function setAttributes(array $attr)
    {
        $this->attributes = $attr;
        
        return $this;
    }
}
