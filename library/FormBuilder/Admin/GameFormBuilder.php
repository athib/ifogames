<?php

namespace FormBuilder\Admin;

use Core\Application;
use Core\Entity;
use Core\PDOFactory;
use FormBuilder\ChoiceField;
use FormBuilder\FileField;
use FormBuilder\FormBuilder;
use FormBuilder\StringField;
use FormBuilder\HiddenField;
use FormBuilder\TextField;
use FormBuilder\Validator\NotNullValidator;
use FormBuilder\Validator\DateFormatValidator;
use Model\EditorManager;
use Model\PlatformManager;

class GameFormBuilder extends FormBuilder
{
    protected $platFormsList;
    protected $editorsList;
    protected $editorSelected = array();

    public function __construct(Entity $entity, Application $app)
    {
        parent::__construct($entity, $app);

        $db = PDOFactory::getMysqlConnexion();
        
        $platforms = (new PlatformManager($db))->getAllPlatforms();
        $editors = (new EditorManager($db))->getAllEditors();
        
        foreach ($platforms as $platform) {
            $this->platFormsList[$platform->getId()] = $platform->getFullname();
        }
        foreach ($editors as $editor) {
            $this->editorsList[$editor->getId()] = $editor->getName();
        }

        if ($this->form->getEntity()->getIdEditor()) {
            $this->editorSelected = array($this->form->getEntity()->getIdEditor(), '');
        }
    }

    public function build()
    {
        $placeholderTitle = $this->translator->get('validator.placeholder.title');
        $placeholderDescription = $this->translator->get('validator.placeholder.description');
        $placeholderReleaseDate = $this->translator->get('validator.placeholder.release_date');

        $this->form
            ->add(new HiddenField([
                'name' => 'id',
            ]))
            ->add(new StringField([
                'name' => 'title',
                'label' => $this->getApp()->getTranslator()->get('admin.addgame_form.title'),
                'validators' => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderTitle)),
                ],
            ]))
            ->add(new TextField([
                'name' => 'description',
                'label' => $this->getApp()->getTranslator()->get('admin.addgame_form.description'),
                'rows' => 5,
                'cols' => 70,
                'validators' => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderDescription))
                ],
            ]))
            ->add(new ChoiceField([
                'name' => 'editor',
                'label' => $this->translator->get('admin.addgame_form.editor'),
                'optionsSelected' => $this->editorSelected,
                'options' => $this->editorsList,
            ]))
            ->add(new StringField([
                'name' => 'releaseDate',
                'label' => $this->translator->get('admin.addgame_form.release_date'),
                'classes' => ['datepicker'],
                'validators' => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderReleaseDate)),
                    new DateFormatValidator($this->translator->get('validator.form.date', $placeholderReleaseDate)),
                ],
            ]))
            ->add(new StringField([
                'name' => 'price',
                'label' => $this->translator->get('admin.addgame_form.price'),
                'validators' => [
                    new NotNullValidator($this->translator->get('validator.form.not_null', $placeholderReleaseDate)),
                ],
            ]))
            ->add(new ChoiceField([
                'name' => 'pegi',
                'label' => $this->translator->get('admin.addgame_form.pegi'),
                'optionsSelected' => array($this->form->getEntity()->getPegi() => $this->form->getEntity()->getPegi()),
                'options' => [
                    'all' => $this->translator->get('shop.game.pegi_all'),
                    '3' => $this->translator->get('shop.game.pegi_3'),
                    '7' => $this->translator->get('shop.game.pegi_7'),
                    '12' => $this->translator->get('shop.game.pegi_12'),
                    '16' => $this->translator->get('shop.game.pegi_16'),
                    '18' => $this->translator->get('shop.game.pegi_18'),
                ],
            ]))
            ->add(new FileField([
                'name' => 'jacket',
                'label' => $this->translator->get('admin.addgame_form.jacket'),
            ]))
        ;
    }
}
