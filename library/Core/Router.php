<?php
namespace Core;

/**
 * Class Router
 * Modélise le Routeur de l'application. Il gère les URL's et permet de vérifier s'ils correspondent à une route définie dans la configuration
 *
 * @package Core
 */
class Router
{
    /**************** PROPRIETES ****************/
    
    const NO_ROUTE_FOUND = 1;
    protected $routes = []; // liste des routes (chargées depuis fichier de config routes.xml)
    
    
    /**************** METHODES ****************/
    
    /**
     * Méthode qui ajoute une Route au Router
     * Vérifie si la route n'est pas déjà définie avant
     *
     * @param Route $route la route à ajouter
     */
    public function addRoute(Route $route)
    {
        // Si elle n'existe pas déjà
        if (!in_array($route, $this->routes)) {
            $this->routes[] = $route;
        }
    }
    
    /**
     * Méthode qui retourne la Route correspondant à l'url passée en paramètre
     *
     * @param $url L'url à vérifier
     * @throws \RuntimeException Une exception qui est levée si la route demandée n'existe pas
     *
     * @return mixed La Route si elle existe
     */
    public function getRoute($url)
    {
        // On parcours toutes les routes contenues dans le Router
        foreach ($this->routes as $route) {
            // On teste l'existence de la route
            $routeAndVars = $route->match($url);
            
            // Si la route correspond à l'URL
            if ($routeAndVars !== false) {
                // Si la route contient des variables
                if ($route->hasVars()) {
                    // On commence par récupérer la liste
                    $varsList = $route->getVarsList();
                    
                    // On crée un nouveau tableau clé/valeur
                    $listVars = [];
                    
                    foreach ($routeAndVars as $key => $value) {
                        // preg_match renvoie un tableau dont le 1er indice contient la chaine entière
                        // Seules les paranthèses capturantes (et donc les paramètres nous intéressent)
                        // Donc si on est à l'indice 0, on passe à l'itération suivante
                        if ($key === 0) {
                            continue;
                        }
                        
                        // On ajoute la variable et sa valeur à la liste
                        $listVars[$varsList[$key - 1]] = $value;
                    }
                    // On assigne ce tableau de variables à la route
                    $route->setVars($listVars);
                }
                
                return $route;
            }
        }
        throw new \RuntimeException('Aucune route ne correspond à l\'URL.', self::NO_ROUTE_FOUND);
    }
}
