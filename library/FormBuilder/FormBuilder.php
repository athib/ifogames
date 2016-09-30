<?php

namespace FormBuilder;

use Core\Application;
use Core\ApplicationComponent;
use Core\Entity;

/**
 * Class FormBuilder
 * Classe de base pour tous les constructeurs de formulaire
 */
abstract class FormBuilder extends ApplicationComponent
{
    const PATTERN_NAME = '#^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ-]{3,30}$#';
    const PATTERN_USERNAME = '#^[\w-_.]{3,20}$#';
    const PATTERN_PASSWORD = '#^\w{3,10}$#';
    const PATTERN_EMAIL = '#^[a-z0-9-_.]+@[a-z0-9-.]+\.[a-z]{2,}$#';
    const PATTERN_POSTAL_CODE = '#^\d{5}$#';
    const PATTERN_PHONE = '#^\d{10}$#';
    
    protected $form;
    protected $translator;

    public function __construct(Entity $entity, Application $app)
    {
        parent::__construct($app);
        
        $this->setForm(new Form($entity));
        $this->translator = $app->getTranslator();
    }

    abstract public function build();

    public function setForm(Form $form)
    {
        $this->form = $form;
        
        return $this;
    }

    public function getForm()
    {
        return $this->form;
    }
}
