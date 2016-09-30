<?php

namespace Core;

session_start();

use Entity\Member;
use Model\MemberManager;

/**
 * Class Application
 *
 * Modélise l'application de façon abstraite.
 * Un nom, un utilisateur, une configuration, une réponse HTTP et une requête HTTP
 * Cette classe sera héritée pour définir les applications Frontend (visible par l'utilisateur lambda)
 * et Backend (partie admin)
 */
abstract class Application
{
    /****************** PROPRIETES ******************/
    
    protected $httpRequest;
    protected $httpResponse;
    protected $name;
    protected $member;
    protected $config;
    protected $roles;

    protected static $translator;
    
    
    /****************** CONSTRUCTEUR ******************/
    
    public function __construct()
    {
        // initialisation des objets Requête et Réponse, en leur passant l'instance de l'app (this)
        $this->httpRequest  = new HTTPRequest($this);
        $this->httpResponse = new HTTPResponse($this);
        
        // Si un membre est connecté, et définie dans la variable de Session, on récupère son instance
        $this->member = $this->hasMember() ? $_SESSION['member'] : new Member();
        
        // On récupère les variables définies par le fichier de configuration
        $this->config = new Config($this);

        // On récupère la hiérarchie des Rôles
        $this->roles = new Role();
        
        // A l'instanciation de la classe, le nom n'est pas encore défini
        $this->name = '';
    }
    
    
    /****************** METHODES ******************/
    
    /**
     * Méthode qui renvoie le controller correspondant à la route appelée (url)
     *
     * @return mixed
     */
    public function getController()
    {
        /* On commence par traiter les informations de la route pour déduire le controller */
        // On instancie un nouveau Router
        $router = new Router();
        
        // Chargement du fichier de configuration des routes
        $xml = new \DOMDocument;
        $xml->load(__DIR__ . '/../../App/Config/routes.xml');
        // On récupère toutes les balises "route"
        $routes = $xml->getElementsByTagName('route');
        
        // On parcourt toutes les routes (du fichier)
        foreach ($routes as $route) {
            $vars = [];
            // Si un attribut 'vars' a été défini dans la config de la route
            // On récupère la liste de toutes les variables dans un tableau
            if ($route->hasAttribute('vars')) {
                $vars = explode(',', $route->getAttribute('vars'));
            }
            
            // on récupère les valeurs
            $url    = $route->getAttribute('url');
            $module = $route->getAttribute('module');
            $action = $route->getAttribute('action');
            
            // On instancie une Route
            $newRoute = new Route($url, $module, $action, $vars);
            
            // On ajoute la route au routeur.
            $router->addRoute($newRoute);
        }
        
        // On récupère la route correspondante à l'URL.
        // la méthode getRoute lève une exception lorsque la route n'existe pas
        try {
            $matchedRoute = $router->getRoute($this->httpRequest->getRequestURI());
        } catch (\RuntimeException $e) {
            if ($e->getCode() == Router::NO_ROUTE_FOUND) {
                // Si aucune route ne correspond, c'est que la page demandée n'existe pas,
                // alors on redirige vers la page 404.
                $this->httpResponse->redirect404($e->getMessage());
            }
        }
        
        // On ajoute les variables de l'URL au tableau $_GET.
        $_GET = array_merge($_GET, $matchedRoute->getVars());
        
        // On instancie le contrôleur.
        $controllerClass = 'App\\' . $this->name . '\\Modules\\' . $matchedRoute->getModule() . '\\' . $matchedRoute->getModule() . 'Controller';
        
        return new $controllerClass($this, $matchedRoute->getModule(), $matchedRoute->getAction());
    }
    
    // Méthode qui sera définie dans les classes filles
    abstract public function run();
    
    /**
     * Méthode qui indique si le Membre possède l'accès demandé
     *
     * @param Member $member Le membre pour lequel vérifier les accès
     * @param $roleToCheck Le rôle à vérifier pour le membre
     *
     * @return bool TRUE si le membre a l'accès, FALSE si non
     */
    public function isGranted(Member $member, $roleToCheck)
    {
        // Liste des accès autorisés pour le $role_to_check
        $list = $this->roles->getRoles($member->getRole());
        
        if (in_array($roleToCheck, $list)) {
            return true;
        }
        
        return false;
    }
    
    /*public function saveToSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public function getFromSession($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }*/
    
    
    /****************** GETTERS ******************/
    
    public function getHttpRequest()
    {
        return $this->httpRequest;
    }
    
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getConfig()
    {
        return $this->config;
    }
    
    public function hasMember()
    {
        if (isset($_SESSION['member'])) {
            return true;
        }
        
        return false;
    }
    
    public function getMember()
    {
        return $this->member;
    }
    
    public static function getTranslator()
    {
        return self::$translator;
    }
    
    public function setMember(Member $member)
    {
        $this->member = $member;
        $_SESSION['member'] = $member;
    }
    
    public function getSession($key)
    {
        if (!isset($_SESSION[$key])) {
            return null;
        }
        
        return $_SESSION[$key];
    }
    
    public function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}
