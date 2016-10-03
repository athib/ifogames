<?php

namespace FormBuilder\Validator;

/**
 * Class NumericValidator
 * Permet de valider la contrainte sur les nombres
 *
 * @package FormBuilder\Validator
 */
class NumericValidator extends Validator
{
    public function isValid($value)
    {
        return is_numeric($value);
    }
}
