<?php
namespace App\Backend;

use Core\Application;
use Core\Translator;

/**
 * Class BackendApplication
 * Représente l'application côté Administrateur (Personne d'autre n'a accès à cette partie du site)
 *
 * @package App\Backend
 */
class BackendApplication extends Application
{
    /**
     * BackendApplication constructor.
     * Surcharge du constructeur pour définir le nom de l'application
     */
    public function __construct()
    {
        parent::__construct();
        $this->name = 'Backend';
    }
    
    /**
     * Exécution de l'application
     */
    public function run()
    {
        // On récupère le controlleur UNIQUEMENT si l'utilisateur est authentifié et Admin
        if ($this->member->isAuthenticated() && $this->isGranted($this->member, 'ROLE_ADMIN')) {
            $controller = $this->getController();
            self::$translator = new Translator($this);
        } else {
            $this->httpResponse->redirect('/ifogames/fr/login');
        }
        // On exécute l'action définie dans le controlleur
        $controller->executeAction();
    
        // On génère la page et on l'attribut à la Réponse qui sera renvoyée à l'utilisateur
        $this->httpResponse->setPage($controller->getPage());
    
        // On renvoie la réponse à l'utilisateur
        $this->httpResponse->send();
    }
}