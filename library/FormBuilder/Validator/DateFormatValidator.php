<?php

namespace FormBuilder\Validator;

/**
 * Class DateFormatValidator
 * Permet de valider la contrainte de format de date
 *
 * @package FormBuilder\Validator
 */
class DateFormatValidator extends Validator
{
    public function isValid($value)
    {
        if (!preg_match('#^\d{4}-\d{2}-\d{2}$#', $value)) {
            return false;
        }

        return true;
    }
}
