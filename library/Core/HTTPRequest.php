<?php
namespace Core;

/**
 * Class HTTPRequest
 * Modélise la requête HTTP lancée par l'utilisateur sous forme d'objet
 *
 * Différentes méthodes permettent de tester l'existence des variables comme $_GET, $_POST, $_COOKIE,
 * et de récupérer leur valeur.
 *
 * @package Core
 */
class HTTPRequest extends ApplicationComponent
{
    // Renvoie l'url (= la route)
    public function getRequestURI()
    {
        return $_SERVER['REQUEST_URI'];
    }
    
    // Retourne le type de la requête (GET, POST)
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    // Vérifie si la requête est effectué en AJAX
    public function isXHR()
    {
        $bool = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        return $bool;
    }
    
    // Test l'existence de l'index $key dans la super globale $_COOKIE
    public function hasCookie($key)
    {
        return isset($_COOKIE[$key]);
    }
    
    // Retourne la valeur de $_COOKIE à l'index $key
    public function getCookie($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }
    
    // Test l'existence de l'index $key dans la super globale $_GET
    public function hasGet($key)
    {
        return isset($_GET[$key]);
    }
    
    // Retourne la valeur de $_GET à l'index $key
    public function getGet($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }
    
    // Test l'existence de l'index $key dans la super globale $_GET
    public function hasPost($key)
    {
        return isset($_POST[$key]);
    }
    
    // Retourne la valeur de $_POST à l'index $key
    public function getPost($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }
    
    public function hasFile($string)
    {
        return isset($_FILES[$string]) && !empty($_FILES[$string]['name']);
    }
    
    public function getFile($string)
    {
        return isset($_FILES[$string]['name']) && !empty($_FILES[$string]['name']) ? $_FILES[$string] : null;
    }
}
