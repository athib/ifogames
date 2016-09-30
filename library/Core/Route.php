<?php
namespace Core;

/**
 * Class Route
 * Classe modélisant une route (cad une url) sous forme d'objet.
 * A une route correspond : une url, un module (controller), une action et une liste de variables
 *
 * @package Core
 */
class Route
{
    /**************** PROPRIETES ****************/
    
    protected $url;
    protected $module;
    protected $action;
    protected $varsList; // liste des variables sous forme de chaîne (fichier routes.xml)
    protected $vars = []; // variables et leur valeur
    
    
    /**************** CONSTRUCTEUR ****************/
    /**
     * Route constructor.
     *
     * @param $url
     * @param $module
     * @param $action
     * @param array $varsList
     */
    public function __construct($url, $module, $action, array $varsList)
    {
        $this->setUrl($url);
        $this->setModule($module);
        $this->setAction($action);
        $this->setVarsList($varsList);
    }
    
    
    /**************** METHODES ****************/
    
    /**
     * Indique si la route contient des variables
     *
     * @return bool TRUE s'il y a des variables, FALSE sinon
     */
    public function hasVars()
    {
        return !empty($this->varsList);
    }
    
    /**
     * Vérifie si l'url passée en paramètre correspond à cette route
     * Si oui, on retourne un tableau contenant l'url et les paramètres (parenthèses capturantes)
     * grâce à preg_match
     *
     * @param $url L'URL à chercher
     *
     * @return bool FALSE si la route ne correspond pas
     */
    public function match($url)
    {
        if (preg_match('#^'.$this->url.'$#', $url, $matches)) {
            return $matches;
        }
        
        return false;
    }
    
    /**************** GETTERS ****************/
    
    public function getAction()
    {
        return $this->action;
    }
    
    public function getModule()
    {
        return $this->module;
    }
    
    public function getVars()
    {
        return $this->vars;
    }
    
    public function getVarsList()
    {
        return $this->varsList;
    }
    
    
    /**************** SETTERS ****************/
    
    public function setAction($action)
    {
        // L'action doit être une chaîne de caractères
        if (is_string($action)) {
            $this->action = $action;
        }
    }
    
    public function setModule($module)
    {
        // Le module doit être une chaîne de caractères
        if (is_string($module)) {
            $this->module = $module;
        }
    }
    
    public function setUrl($url)
    {
        // L'url doit être une chaîne de caractères
        if (is_string($url)) {
            $this->url = $url;
        }
    }
    
    public function setVarsList(array $varsList)
    {
        $this->varsList = $varsList;
    }
    
    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }
}
