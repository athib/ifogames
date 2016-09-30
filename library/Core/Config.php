<?php
namespace Core;

/**
 * Class Config
 * Charge le fichier de configuration défini dans App/[Frontend|Backend]/Config/parameters.xml
 * Et implémente une méthode permettant de retourner la valeur d'une variable, ou NULL si elle
 * n'existe pas
 *
 * @package Core
 */
class Config extends ApplicationComponent
{
    protected $vars = [];

    public function __construct()
    {
        // On charge le fichier xml
        $xml = new \DOMDocument;
        $xml->load(__DIR__.'/../../App/Config/parameters.xml');

        // On récupère tous les blocs <define> qui définissent les variables
        $elements = $xml->getElementsByTagName('define');

        // Pour chaque bloc, on récupère la variable et sa valeur
        foreach ($elements as $element) {
            if ($element->hasAttribute('values')) {
                $this->vars[$element->getAttribute('var')] = explode(',', $element->getAttribute('values'));
            } else {
                $this->vars[$element->getAttribute('var')] = $element->getAttribute('value');
            }
        }
    }
    
    /**
     * Méthode retournant la valeur de la variable passée en paramètre
     * La méthode renvoie NULL dans le cas où la variable ne serait pas définie dans la config
     *
     * @param $var La variable à retourner
     * @return mixed|null La valeur de la variable demandée, NULL si la variable n'existe pas
     */
    public function get($var)
    {
        return isset($this->vars[$var]) ? $this->vars[$var] : null;
    }
}
