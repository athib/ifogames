<?php

namespace FormBuilder\Admin;

use Core\Application;
use Core\ArrayCollection;
use Core\Entity;
use Core\PDOFactory;
use FormBuilder\ChoiceField;
use FormBuilder\FormBuilder;
use Model\GenreManager;

class GenreFormBuilder extends FormBuilder
{
    protected $genresList = array();
    protected $genresSelected = array();

    public function __construct(Entity $entity, Application $app, $genresSelected)
    {
        parent::__construct($entity, $app);

        $db = PDOFactory::getMysqlConnexion();
        $genres = (new GenreManager($db))->getAllGenres();

        foreach ($genres as $genre) {
            $this->genresList[$genre->getId()] = $genre->getName();
        }

        if ($genresSelected !== null) {
            foreach ($genresSelected as $selected) {
                $this->genresSelected[$selected->getId()] = $selected->getName();
            }
        }
    }

    public function build()
    {
        $this->form
            ->add(new ChoiceField([
                'name' => 'genres',
                'label' => $this->getApp()->getTranslator()->get('admin.addgame_form.genres'),
                'multiple' => true,
                'optionsSelected' => $this->genresSelected,
                'options' => $this->genresList,
            ]))
        ;
    }
}
