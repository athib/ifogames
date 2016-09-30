<?php
namespace Core;

/**
 * Class Page
 * Modélise un objet représentant une Page que l'on génère selon la requête,
 * puis que l'on renvoie à l'utilisateur
 *
 * @package Core
 */
class Page extends ApplicationComponent
{
    /*************************** PROPRIETES ***************************/
    
    protected $contentFile;
    protected $vars = [];
    
    
    /*************************** METHODES ***************************/
    
    /**
     * Ajoute une variable à la page, si elle n'existe pas déjà
     *
     * @param $var La variable à ajouter
     * @param $value La valeur de la variable à ajouter
     *
     * @throws \InvalidArgumentException L'exception qui est levée si la variable est invalide
     */
    public function addVar($var, $value)
    {
        if (!is_string($var) || is_numeric($var) || empty($var)) {
            throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractères non nulle');
        }
        
        $this->vars[$var] = $value;
    }
    
    /**
     * Ajoute une liste de variables à la page en utilisant la méthode addVar()
     *
     * @param array $vars Un tableau associatif "nom => valeur" de variables à ajouter à la Page
     */
    public function addVars(array $vars)
    {
        foreach ($vars as $key => $value) {
            $this->addVar($key, $value);
        }
    }
    
    /**
     * Renvoie la page générée
     *
     * Ici on on utilise une méthode paticulière : la temporisation de sortie.
     * Cela permet de générer du rendu d'affichage mais de temporiser son envoi au navigateur
     *
     * On peut par exemple appeler un require, générer du code HTML, et cela avant l'appel à un header()
     * sans déclencher une erreur
     *
     * @throws \RuntimeException L'exception qui est levée lorsque l'on tente d'appeler une vue inexistante
     */
    public function getGeneratedPage()
    {
        // Si on est dans une requête AJAX on ne regénère pas une nouvelle page
        if ($this->app->getHttpRequest()->isXHR()) {
            return;
        }
        
        if (!file_exists($this->contentFile)) {
            throw new \RuntimeException('La vue spécifiée n\'existe pas');
        }
        
        $member = $this->app->getMember();
        $translator = $this->app->getTranslator();
        
        if ($translator == null) {
            $translator = new Translator($this->app);
        }
        
        // on importe les variables dans la table des symboles
        // permet de générer des variables utilisable comme si elle avaient été déclarées
        extract($this->vars);
        
        // On démarre la temporisation de sortie
        ob_start();
        
        // on génère le code HTML du contenu de la page (qui s'insère dans le layout, fixe lui)
        include $this->contentFile;
        
        // on récupère ce contenu dans une variable, que l'on pourra afficher dans la vue via echo $content
        $content = ob_get_contents();

        // on vide le tempon pour charger le layout
        ob_clean();
        
        // On charge le layout général
        include __DIR__.'/../../App/'.$this->app->getName().'/layout.php';
        
        // on renvoie le contenu du tempon de sortie
        return ob_get_flush();
    }
    
    /**
     * Définit la vue utilisée dans la Page
     *
     * @param $contentFile La vue à attribuer à la Page
     * @throws \InvalidArgumentException L'eception qui est levée si la vue n'existe pas
     */
    public function setContentFile($contentFile)
    {
        if (!is_string($contentFile) || empty($contentFile)) {
            throw new \InvalidArgumentException('La vue spécifiée est invalide');
        }
        
        $this->contentFile = $contentFile;
    }
}
