<?php
namespace Core;

/**
 * Class ApplicationComponent
 * @package Core
 *
 * Gestionnaire d'objet.
 * Permet simplement d'obtenir l'application à laquelle l'objet appartient.
 */
abstract class ApplicationComponent
{
    protected $app;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    
    public function getApp()
    {
        return $this->app;
    }
}