<?php

namespace FormBuilder\Member;

use FormBuilder\FormBuilder;
use FormBuilder\StringField;
use FormBuilder\Validator\NotNullValidator;

class LoginMemberFormBuilder extends FormBuilder
{
    public function build()
    {
        $placeholderFirstname = $this->translator->get('validator.placeholder.firstname');
        $placeholderPassword = $this->translator->get('validator.placeholder.password');
        
        $this->form

            /*** LOGIN ***/
            ->add(new StringField([
                'name'         => 'username',
                'label'         => $this->getApp()->getTranslator()->get('user.login_form.pseudo'),
                'validators'    => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderFirstname)),
                ]
            ]))
            
            /*** PASSWORD ***/
            ->add(new PasswordField([
                'label'         => $this->getApp()->getTranslator()->get('user.login_form.password'),
                'name'          => 'password',
                'validators'    => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderPassword)),
                ]
            ]))
        ;
    }
}
