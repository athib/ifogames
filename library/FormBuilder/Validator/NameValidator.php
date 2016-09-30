<?php

namespace FormBuilder\Validator;

/**
 * Class NameValidator
 * Permet de valider la contrainte sur les noms
 *
 * @package FormBuilder\Validator
 */
class NameValidator extends Validator
{
    public function isValid($value)
    {
        if (!preg_match('#^[a-zA-Z]{3,}$#', $value)) {
            return false;
        }

        return true;
    }
}
