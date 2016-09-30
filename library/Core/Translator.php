<?php
namespace Core;

/**
 * Class Translator
 * Charge le fichier des traductions dans une langue donnée
 *
 * @package Core
 */
class Translator extends ApplicationComponent
{
    private static $available_locales;
    private static $default_locale;

    protected $translations = [];
    
    /**
     * Translator constructor.
     * On récupère dans le fichier de configuration, la langue par défaut, ainsi que les langues disponibles
     * On défini la langue actuelle et on charge le fichier des traductions correspondant
     *
     * @param Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        self::$available_locales = $this->app->getConfig()->get('available_locales');
        self::$default_locale = $this->app->getConfig()->get('default_locale');

        $this->setLocale($this->getApp()->getHttpRequest()->getGet('locale'));

        // On charge le fichier xml
        $xml = new \DOMDocument;
        $xml->load('resources/translations/' . $this->getLocale() . '.xml');

        // On récupère tous les blocs <trans> qui définissent les clés de traduction
        $elements = $xml->getElementsByTagName('trans');

        // Pour chaque bloc, on récupère la variable et sa valeur
        foreach ($elements as $element) {
            //$this->translations[$element->getAttribute('var')] = $element->getAttribute('value');
            $this->translations[$element->getAttribute('var')] = $element->nodeValue;
        }
    }
    
    /**
     * Méthode qui renvoie la correspondance d'une clé de traduction, dans la langue définie au préalable
     * Si la clé n'existe pas, on renvoie la clé elle-même. C'est un bon moyen de visualiser sur le site quelle clé n'a pas été traduite.
     *
     * @param $trans La clé de traduction
     * @param null $placeholder Pour certaines clé, une variable peut être définie. Par exemple pour le "Bienvenue", on passe le nom de l'utilisateur en paramètre.
     *
     * @return mixed On renvoie la traduction si elle existe, ou la clé initiale sinon
     */
    public function get($trans, $placeholder = null)
    {
        // Si la clé de traduction existe
        if (isset($this->translations[$trans])) {
            // Et si un placeholder est définie pour cette clé
            if ($placeholder) {
                return str_replace('%placeholder%', $placeholder, $this->translations[$trans]);
            }

            return $this->translations[$trans];
        } else { // Sinon on retourne la clé non traduite.
            return $trans;
        }
    }
    
    /**
     * Méthode qui renvoie la langue actuelle si elle est définie, la langue par défaut sinon
     * @return mixed
     */
    public function getLocale()
    {
        return isset($_SESSION['locale']) ? $_SESSION['locale'] : self::DEFAULT_LOCALE;
    }
    
    /**
     * Méthode qui définit la langue actuelle, si elle fait partie des langue disponibles, et qu'elle respecte le format de langue (2 lettres minuscules)
     *
     * @param $locale La langue que l'on veut définir.
     */
    public function setLocale($locale)
    {
        if (!in_array($locale, self::$available_locales)) {
            $_SESSION['locale'] = self::$default_locale;
            $this->app->getHttpResponse()->addFlashes('danger', 'Désolé, l\'url saisie ne mène nulle part.<br /> Nous vous avons ramené sur la page d\'accueil.');
            $this->app->getHttpResponse()->redirect(ROOTADDRESS.'/fr/');
        } else {
            $_SESSION['locale'] = $locale;
        }
    }
}
