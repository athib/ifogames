<?php
namespace App\Frontend;

use \Core\Application;
use Core\Translator;

/**
 * Class FrontendApplication
 * Représente l'application côté utilisateur (du simple visiteur au membre connecté)
 *
 * @package App\Frontend
 */
class FrontendApplication extends Application
{
    /**
     * FrontendApplication constructor.
     * Surcharge du constructeur pour définir le nom de l'application
     */
    public function __construct()
    {
        parent::__construct();
        $this->name = 'Frontend';
    }

    /**
     * Exécution de l'application
     */
    public function run()
    {
        try {
            // On récupère le controlleur correspondant à la route
            $controller = $this->getController();

            // Initialisation du service de traduction
            self::$translator = new Translator($this);
        } catch (\Exception $e) {
            $this->httpResponse->redirect404();
            exit();
        }

        // On exécute l'action demandée (par la route)
        $controller->executeAction();

        // On génère la page et on l'attribut à la Réponse qui sera renvoyée à l'utilisateur
        $this->httpResponse->setPage($controller->getPage());

        // On renvoie la réponse à l'utilisateur
        $this->httpResponse->send();
    }
}
