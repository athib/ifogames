<?php

namespace FormBuilder\Admin;

use Core\Application;
use Core\Entity;
use Core\PDOFactory;
use FormBuilder\ChoiceField;
use FormBuilder\FormBuilder;
use Model\PlatformManager;

class PlatformFormBuilder extends FormBuilder
{
    protected $platformsList = array();
    protected $platformsSelected = array();

    public function __construct(Entity $entity, Application $app, $platformsSelected)
    {
        parent::__construct($entity, $app);

        $db = PDOFactory::getMysqlConnexion();
        $platforms = (new PlatformManager($db))->getAllPlatforms();

        foreach ($platforms as $platform) {
            $this->platformsList[$platform->getId()] = $platform->getFullName();
        }

        if ($platformsSelected !== null) {
            foreach ($platformsSelected as $selected) {
                $this->platformsSelected[$selected->getId()] = $selected->getFullName();
            }
        }
    }

    public function build()
    {
        $this->form
            ->add(new ChoiceField([
                'name' => 'platforms',
                'label' => $this->getApp()->getTranslator()->get('admin.addgame_form.platforms'),
                'multiple' => true,
                'optionsSelected' => $this->platformsSelected,
                'options' => $this->platformsList,
            ]))
        ;
    }
}
