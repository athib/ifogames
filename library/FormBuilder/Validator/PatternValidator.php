<?php

namespace FormBuilder\Validator;

/**
 * Class PatternValidator
 * Permet de valider une contrainte de formatage de texte
 *
 * @package FormBuilder\Validator
 */
class PatternValidator extends Validator
{
    protected $pattern;


    public function __construct($errorMessage, $pattern = null)
    {
        parent::__construct($errorMessage);

        $this->setPattern($pattern);
    }

    public function isValid($value)
    {
        if ($this->pattern === null) {
            return true;
        }
        
        return preg_match($this->pattern, $value);
    }

    public function setPattern($pattern)
    {
        if (!is_string($pattern)) {
            throw new \RuntimeException('Le pattern d\'un champ texte doit être une châine de caractères.');
        }
        $this->pattern = $pattern;
        
        return $this;
    }
}
