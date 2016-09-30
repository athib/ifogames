<?php

namespace FormBuilder\Validator;

/**
 * Class MaxLengthValidator
 * Permet de valider une contrainte de longueur maximale
 * 
 * @package FormBuilder\Validator
 */
class MaxLengthValidator extends Validator
{
    protected $maxLength;


    public function __construct($errorMessage, $maxLength)
    {
        parent::__construct($errorMessage);

        $this->setMaxLength($maxLength);
    }

    public function isValid($value)
    {
        return strlen($value) <= $this->maxLength;
    }

    public function setMaxLength($maxLength)
    {
        if (!is_int($maxLength) || $maxLength <= 0) {
            throw new \RuntimeException('La longueur maximale doit être un nombre entier supérieur à 0.');
        }
        $this->maxLength = $maxLength;
        
        return $this;
    }
}
