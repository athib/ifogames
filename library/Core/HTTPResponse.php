<?php
namespace Core;

/**
 * Class HTTPResponse
 * Modélise la réponse HTTP renvoyée par le serveur à l'utilisateur, sous forme d'objet
 *
 * @package Core
 */
class HTTPResponse extends ApplicationComponent
{
    protected $page;
    
    // Ajoute un entête à la page qui sera générée (utile pour erreur 404 par exemple)
    public function addHeader($header)
    {
        header($header);
    }
    
    // Permet une redirection vers la route $location
    public function redirect($location)
    {
        header('Location: ' . $location);
        exit();
    }
    
    // Redirection vers une erreur 404 personnalisée
    public function redirect404($message = null)
    {
        $this->page = new Page($this->app);
        $this->page->setContentFile('Errors/404.php');
        $this->page->addVar('message', $message);
        $this->addHeader('HTTP/1.0 404 Not Found');
        $this->send();
    }
    
    // Envoie la réponse, cad génère la page à afficher.
    public function send()
    {
        $this->page->getGeneratedPage();
        exit();
    }
    
    // Setter de la propriété $this->page
    public function setPage(Page $page)
    {
        $this->page = $page;
    }


    public function hasFlashes()
    {
        return isset($_SESSION['flash']);
    }

    public function addFlashes($type, $message)
    {
        $_SESSION['flash'][$type][] = "$message";
    }

    public function getFlashes()
    {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);

        return $flash;
    }
}
