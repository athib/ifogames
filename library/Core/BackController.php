<?php
namespace Core;

/**
 * Class BackController
 * Classe abstraite définissant la base de tous les controlleurs : le module, l'action, la page, la vue
 * et les managers (pour contrôler les entités, et la connexion à la base de données)
 *
 * @package Core
 */
abstract class BackController extends ApplicationComponent
{
    /********************** PROPRIETES **********************/
    
    protected $action = '';
    protected $module = '';
    protected $page = null;
    protected $view = '';
    protected $managers = null;
    
    
    /********************** CONSTRUCTEUR **********************/
    
    public function __construct(Application $app, $module, $action)
    {
        parent::__construct($app);
        
        $this->managers = new Managers(PDOFactory::getMysqlConnexion());
        $this->page     = new Page($app);
        $this->setModule($module);
        $this->setAction($action);
        $this->setView($action); // l'action et la vue ont le même nom, par convention
    }
    
    
    
    /********************** METHODES **********************/
    
    // Exécute l'action définie dans la route et à l'appel du controlleur
    public function executeAction()
    {
        $method = $this->action . 'Action';
        
        // Si l'action n'existe pas, on lève une exception
        if (!is_callable([$this, $method])) {
            throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce module');
        }
        
        $this->$method($this->app->getHttpRequest());
    }
    
    
    /********************** GETTERS **********************/
    
    public function getPage()
    {
        return $this->page;
    }
    
    
    /********************** SETTERS **********************/
    
    public function setModule($module)
    {
        if (!is_string($module) || empty($module)) {
            throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
        }
        
        $this->module = $module;
    }
    
    public function setAction($action)
    {
        if (!is_string($action) || empty($action)) {
            throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
        }
        
        $this->action = $action;
    }
    
    public function setView($view)
    {
        if (!is_string($view) || empty($view)) {
            throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
        }
        
        $this->view = $view;
        
        $this->page->setContentFile(__DIR__.'/../../App/'.$this->app->getName().'/Modules/'.$this->module.'/Views/'.$this->view.'.php');
    }
}
