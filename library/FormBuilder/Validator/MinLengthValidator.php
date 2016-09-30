<?php

namespace FormBuilder\Validator;

/**
 * Class MinLengthValidator
 * Permet de valider une contrainte de longueur minimale
 *
 * @package FormBuilder\Validator
 */
class MinLengthValidator extends Validator
{
    protected $minLength;
    
    
    public function __construct($errorMessage, $minLength)
    {
        parent::__construct($errorMessage);
        
        $this->setMinLength($minLength);
    }
    
    public function isValid($value)
    {
        return strlen($value) >= $this->minLength;
    }
    
    public function setMinLength($minLength)
    {
        if (!is_int($minLength) || $minLength < 0) {
            throw new \RuntimeException('La longueur maximale doit être un nombre entier supérieur ou égal à 0.');
        }
        $this->minLength = $minLength;
        
        return $this;
    }
}
