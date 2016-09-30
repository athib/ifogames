<?php

namespace FormBuilder\Shop;

use FormBuilder\CheckboxField;
use FormBuilder\FormBuilder;
use FormBuilder\StringField;
use FormBuilder\EmailField;
use FormBuilder\Validator\NotNullValidator;
use FormBuilder\Validator\MaxLengthValidator;
use FormBuilder\Validator\MinLengthValidator;
use FormBuilder\Validator\PatternValidator;

class CheckoutFormBuilder extends FormBuilder
{
    public function build()
    {
        // TODO : configurer les validateurs (patterns)

        $placeholderFirstname = $this->translator->get('validator.placeholder.firstname');
        $placeholderLastname = $this->translator->get('validator.placeholder.lastname');
        $placeholderBillingAddress = $this->translator->get('validator.placeholder.billing_address');
        $placeholderBillingCity = $this->translator->get('validator.placeholder.billing_city');
        $placeholderBillingPostalCode = $this->translator->get('validator.placeholder.billing_postalcode');
        $placeholderMailingAddress = $this->translator->get('validator.placeholder.mailing_address');
        $placeholderMailingCity = $this->translator->get('validator.placeholder.mailing_city');
        $placeholderMailingPostalCode = $this->translator->get('validator.placeholder.mailing_postalcode');
        $placeholderEmail = $this->translator->get('validator.placeholder.email');
        $placeholderPhone = $this->translator->get('validator.placeholder.phone');


        $this->form
            ->startFieldset($this->translator->get('form.checkout.fieldset_member'))
                ->add(new StringField([
                    'name'       => 'firstname',
                    'maxlength'  => 30,
                    'label'      => $this->translator->get('form.generic.firstname'),
                    'validators' => [
                        new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderFirstname)),
                        new MaxLengthValidator($this->translator->get('validator.form.max_length', $placeholderFirstname).$this->translator->get('validator.placeholder.max_value', 30), 30),
                        new MinLengthValidator($this->translator->get('validator.form.min_length', $placeholderFirstname).$this->translator->get('validator.placeholder.min_value', 3), 3),
                    ]
                ]))
                ->add(new StringField([
                    'name'       => 'lastname',
                    'maxlength'  => 30,
                    'label'      => $this->translator->get('form.generic.lastname'),
                    'validators' => [
                        new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderLastname)),
                        new MaxLengthValidator($this->translator->get('validator.form.max_length', $placeholderLastname).$this->translator->get('validator.placeholder.max_value', 30), 30),
                        new MinLengthValidator($this->translator->get('validator.form.min_length', $placeholderLastname).$this->translator->get('validator.placeholder.min_value', 3), 3),
                    ]
                ]))
                ->add(new EmailField([
                    'label'      => $this->getApp()->getTranslator()->get('form.generic.email'),
                    'name'       => 'email',
                    'maxlength'  => 45,
                    'validators' => [
                        new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderEmail)),
                        new MaxLengthValidator($this->translator->get('validator.form.max_length', $placeholderEmail).$this->translator->get('validator.placeholder.max_value', 45), 45),
                        new PatternValidator($this->translator->get('validator.form.pattern', $placeholderEmail), self::PATTERN_EMAIL),
                    ]
                ]))
                ->add(new StringField([
                    'name'          => 'phone',
                    'maxlength'     => 10,
                    'label'         => $this->translator->get('form.generic.phone'),
                    'validators'    => [
                        new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderPhone)),
                        new PatternValidator($this->translator->get('validator.form.pattern', $placeholderPhone), self::PATTERN_PHONE),
                    ]
                ]))
            ->endFieldset()

            ->startFieldset($this->translator->get('form.checkout.fieldset_billing'))
                ->add(new StringField([
                    'name'          => 'billingStreet',
                    'maxlength'     => 255,
                    'label'         => $this->translator->get('form.generic.street'),
                    'validators'    => [
                        new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderBillingAddress)),
                        new MaxLengthValidator($this->translator->get('validator.form.max_length', $placeholderBillingAddress).$this->translator->get('validator.placeholder.max_value', 255), 255),
                        new MinLengthValidator($this->translator->get('validator.form.min_length', $placeholderBillingAddress).$this->translator->get('validator.placeholder.min_value', 3), 3),
                    ]
                ]))
                ->add(new StringField([
                    'name'          => 'billingCity',
                    'maxlength'     => 100,
                    'label'         => $this->translator->get('form.generic.city'),
                    'validators'    => [
                        new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderBillingCity)),
                        new MaxLengthValidator($this->translator->get('validator.form.max_length', $placeholderBillingCity).$this->translator->get('validator.placeholder.max_value', 100), 100),
                        new MinLengthValidator($this->translator->get('validator.form.min_length', $placeholderBillingCity).$this->translator->get('validator.placeholder.min_value', 3), 3),
                    ]
                ]))
                ->add(new StringField([
                    'name'          => 'billingPostalCode',
                    'maxlength'     => 5,
                    'label'         => $this->translator->get('form.generic.postal_code'),
                    'validators'    => [
                        new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderBillingPostalCode)),
                        new PatternValidator($this->translator->get('validator.form.pattern', $placeholderBillingPostalCode), self::PATTERN_POSTAL_CODE),
                    ]
                ]))
            ->endFieldset()

            ->startFieldset($this->translator->get('form.checkout.fieldset_mailing'))
            ->add(new CheckboxField([
                'name' => 'sameAsBilling',
                'checked' => true,
                'label' => $this->translator->get('form.checkout.same_as_billing'),
            ]))
            ->add(new StringField([
                'name'          => 'mailingStreet',
                'maxlength'     => 255,
                'label'         => $this->translator->get('form.generic.street'),
                'classes'       => array('hidden-if-checked'),
                'validators'    => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderMailingAddress)),
                    new MaxLengthValidator($this->translator->get('validator.form.max_length', $placeholderMailingAddress).$this->translator->get('validator.placeholder.max_value', 255), 255),
                    new MinLengthValidator($this->translator->get('validator.form.min_length', $placeholderMailingAddress).$this->translator->get('validator.placeholder.min_value', 3), 3),
                ]
            ]))
            ->add(new StringField([
                'name'          => 'mailingCity',
                'maxlength'     => 100,
                'label'         => $this->translator->get('form.generic.city'),
                'classes'       => array('hidden-if-checked'),
                'validators'    => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderMailingCity)),
                    new MaxLengthValidator($this->translator->get('validator.form.max_length', $placeholderMailingCity).$this->translator->get('validator.placeholder.max_value', 100), 100),
                    new MinLengthValidator($this->translator->get('validator.form.min_length', $placeholderMailingCity).$this->translator->get('validator.placeholder.min_value', 3), 3),
                ]
            ]))
            ->add(new StringField([
                'name'          => 'mailingPostalCode',
                'maxlength'     => 5,
                'label'         => $this->translator->get('form.generic.postal_code'),
                'classes'       => array('hidden-if-checked'),
                'validators'    => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderMailingPostalCode)),
                    new PatternValidator($this->translator->get('validator.form.pattern', $placeholderMailingPostalCode), self::PATTERN_POSTAL_CODE),
                ]
            ]))
            ->endFieldset()
        ;
    }
}
