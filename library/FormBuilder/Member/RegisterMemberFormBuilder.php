<?php

namespace FormBuilder\Member;

use FormBuilder\FormBuilder;
use FormBuilder\StringField;
use FormBuilder\EmailField;
use FormBuilder\Validator\MaxLengthValidator;
use FormBuilder\Validator\MinLengthValidator;
use FormBuilder\Validator\NotNullValidator;
use FormBuilder\Validator\PasswordConfirmValidator;
use FormBuilder\Validator\PatternValidator;

class RegisterMemberFormBuilder extends FormBuilder
{
    public function build()
    {
        $placeholderUsername = $this->translator->get('validator.placeholder.username');
        $placeholderEmail = $this->translator->get('validator.placeholder.email');
        $placeholderPassword = $this->translator->get('validator.placeholder.password');

        // TODO : configurer les validateurs
        
        $this->form

            /*** PSEUDO ***/
            ->add(new StringField([
                'name'          => 'username',
                'maxlength'     => 20,
                'label'         => $this->getApp()->getTranslator()->get('user.register_form.pseudo'),
                'validators'    => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderUsername)),
                    new MaxLengthValidator($this->translator->get('validator.form.max_length', $placeholderUsername).$this->translator->get('validator.placeholder.max_value', 20), 20),
                    new MinLengthValidator($this->translator->get('validator.form.min_length', $placeholderUsername).$this->translator->get('validator.placeholder.min_value', 3), 3),
                    new PatternValidator($this->translator->get('validator.form.pattern', $placeholderUsername), self::PATTERN_USERNAME),
                ]
            ]))

            /*** EMAIL ***/
            ->add(new EmailField([
                'label'         => $this->getApp()->getTranslator()->get('user.register_form.email'),
                'name'          => 'email',
                'maxlength'     => 45,
                'validators'    => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderEmail)),
                    new MaxLengthValidator($this->translator->get('validator.form.max_length', $placeholderEmail).$this->translator->get('validator.placeholder.max_value', 45), 45),
                    new PatternValidator($this->translator->get('validator.form.pattern', $placeholderEmail), self::PATTERN_EMAIL),
                ]
            ]))

            /*** PASSWORD ***/
            ->add(new PasswordField([
                'label'         => $this->getApp()->getTranslator()->get('user.register_form.password'),
                'name'          => 'password',
                'maxlength'     => 30,
                'validators'    => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderPassword)),
                    new MaxLengthValidator($this->translator->get('validator.form.max_length', $placeholderPassword).$this->translator->get('validator.placeholder.max_value', 30), 30),
                    new MinLengthValidator($this->translator->get('validator.form.min_length', $placeholderPassword).$this->translator->get('validator.placeholder.min_value', 3), 3),
                    new PatternValidator($this->translator->get('validator.form.pattern', $placeholderPassword), self::PATTERN_PASSWORD),
                ]
            ]))

            /*** PASSWORD CONFIRMATION ***/
            ->add(new PasswordField([
                'label'         => $this->getApp()->getTranslator()->get('user.register_form.password_confirm'),
                'name'          => 'passwordConfirm',
                'maxlength'     => 30,
                'validators'    => [
                    new PasswordConfirmValidator($this->translator->get('validator.form.password_confirm')),
                ]
            ]))
        ;
    }
}
