<?php

namespace FormBuilder\Member;

use FormBuilder\FormBuilder;
use FormBuilder\HiddenField;
use FormBuilder\StringField;
use FormBuilder\Validator\MaxLengthValidator;
use FormBuilder\Validator\MinLengthValidator;
use FormBuilder\Validator\NotNullValidator;
use FormBuilder\Validator\PatternValidator;
use FormBuilder\Validator\NameValidator;

class MemberFormBuilder extends FormBuilder
{
    public function build()
    {
        $placeholderUsername = $this->translator->get('validator.placeholder.username');
        
        $this->form
            ->add(new HiddenField([
                'name'       => 'id',
                'label'      => $this->translator->get('user.profile.id_member'),
            ]))
            ->add(new StringField([
                'name'       => 'username',
                'label'      => $this->translator->get('user.profile.username'),
                'validators' => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $this->translator->get('user.profile.username'))),
                    new MaxLengthValidator($this->translator->get('validator.form.max_length', $placeholderUsername).$this->translator->get('validator.placeholder.max_value', 20), 20),
                    new MinLengthValidator($this->translator->get('validator.form.min_length', $placeholderUsername).$this->translator->get('validator.placeholder.min_value', 3), 3),
                    new PatternValidator($this->translator->get('validator.form.pattern', $placeholderUsername), self::PATTERN_USERNAME),
                ]
            ]))
            ->add(new StringField([
                'name'       => 'firstname',
                'label'      => $this->translator->get('user.profile.firstname'),
                'validators' => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $this->translator->get('user.profile.firstname'))),
                    new NameValidator($this->translator->get('validator.form.name', $this->translator->get('user.profile.firstname'))),
                ]
            ]))
            ->add(new StringField([
                'name'       => 'lastname',
                'label'      => $this->translator->get('user.profile.lastname'),
                'validators' => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $this->translator->get('user.profile.lastname'))),
                    new NameValidator($this->translator->get('validator.form.name', $this->translator->get('user.profile.lastname'))),
                ]
            ]))
            ->add(new StringField([
                'name'       => 'email',
                'label'      => $this->translator->get('user.profile.email'),
                'validators' => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $this->translator->get('user.profile.email'))),
                ]
            ]))
            ->add(new StringField([
                'name'       => 'phone',
                'label'      => $this->translator->get('user.profile.phone'),
                'validators' => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $this->translator->get('user.profile.phone'))),
                ]
            ]))
        ;
    }
}
