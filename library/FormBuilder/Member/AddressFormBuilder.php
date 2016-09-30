<?php

namespace FormBuilder\Member;

use FormBuilder\FormBuilder;
use FormBuilder\HiddenField;
use FormBuilder\StringField;
use FormBuilder\Validator\NotNullValidator;

class AddressFormBuilder extends FormBuilder
{
    // TODO : configurer les validateurs
    
    public function build()
    {
        $this->form
            ->add(new HiddenField([
                'name'       => 'id',
                'label'      => $this->translator->get('user.profile.address')
            ]))
            ->add(new StringField([
                'name'       => 'street',
                'label'      => $this->translator->get('user.profile.street'),
                'validators' => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $this->translator->get('user.profile.street'))),
                ]
            ]))
            ->add(new StringField([
                'name'       => 'postalCode',
                'label'      => $this->translator->get('user.profile.postal_code'),
                'validators' => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $this->translator->get('user.profile.postal_code'))),
                ]
            ]))
            ->add(new StringField([
                'name'       => 'city',
                'label'      => $this->translator->get('user.profile.city'),
                'validators' => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $this->translator->get('user.profile.city'))),
                ]
            ]))
        ;
    }
}
