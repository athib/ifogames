<?php

namespace FormBuilder\Validator;

/**
 * Class NotNullValidator
 * Permet de valider la contrainte NotNull
 *
 * @package FormBuilder\Validator
 */
class NotNullValidator extends Validator
{
    public function isValid($value)
    {
        return $value != '';
    }
}
