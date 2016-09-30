<?php

namespace FormBuilder;

use FormBuilder\Validator\NotNullValidator;

class ForumPostFormBuilder extends FormBuilder
{
    public function build()
    {
        $this->form->add(new TextField([
            'label' => 'Votre message',
            'name' => 'content',
            'rows' => 7,
            'cols' => 50,
            'validators' => [
                new NotNullValidator('Votre message ne peut pas être vide.')
            ],
        ]));
    }
}
