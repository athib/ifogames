<?php

namespace FormBuilder\Validator;

use Model\MemberManager;

/**
 * Class PasswordConfirmValidator
 * Permet de valider une contrainte de mot de passe identiques
 *
 * @package FormBuilder\Validator
 */
class PasswordConfirmValidator extends Validator
{
    public function isValid($value)
    {
        if ($value === MemberManager::PASSWORD_NOT_CONFIRMED) {
            return false;
        }
        
        return true;
    }
}
