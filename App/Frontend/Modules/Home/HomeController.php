<?php
namespace App\Frontend\Modules\Home;

use \Core\BackController;
use \Core\HTTPRequest;

/**
 * Class HomeController
 *
 * Classe qui représente le controlleur du module Home.
 * Comprend plusieurs méthodes correspondant aux différentes routes accessibles et configurées dans
 * le fichier routes.xml
 *
 * Hérite de BackController, qui sert de base à tous les Controllers de l'application
 *
 * @package App\Frontend\Modules\Home
 */
class HomeController extends BackController
{
    /**
     * Méthode gérant l'affichage de la page d'accueil
     *
     * @param HTTPRequest $request La requête et tous ses paramètres
     */
    public function indexAction(HTTPRequest $request)
    {
        $this->page->addVars([
            'pageTitle' => $this->app->getTranslator()->get('core.page_title.home'),
            'pageActive' => 'home',
        ]);
    }
    
    /**
     * Méthode gérant l'affichage de la page CGV
     * Affichage des Conditions Générales de Vente appliquées sur le site
     *
     * @param HTTPRequest $request La requête et tous ses paramètres
     */
    public function cgvAction(HTTPRequest $request)
    {
        $this->page->addVars([
            'title'      => 'ifogames - CGV',
            'pageActive' => 'cgv',
        ]);
    }

    /**
     * Méthode gérant l'affichage de la page Mentions legales
     *
     * @param HTTPRequest $request La requête et tous ses paramètres
     */
    public function mentionsAction(HTTPRequest $request)
    {
        $this->page->addVars([
            'title'      => 'ifogames - Mentions légales',
            'pageActive' => 'mentions',
        ]);
    }
    
    /**
     * Méthode gérant l'affichage de la page de contact
     * Affichage de toutes les informations nécéssaire pour contacter le gérant du site, trouver les locaux, le plan d'accès... etc.
     *
     * @param HTTPRequest $request La requête et tous ses paramètres
     */
    public function contactAction(HTTPRequest $request)
    {
        $this->page->addVars([
            'title'      => 'Nous contacter',
            'pageActive' => 'contact',
        ]);
    }

    /**
     * Méthode gérant l'affichage de la page Plan du site
     *
     * @param HTTPRequest $request La requête et tous ses paramètres
     */
    public function sitemapAction(HTTPRequest $request)
    {
        $this->page->addVars([
            'title'      => 'ifogames - Plan du site',
            'pageActive' => 'sitemap',
        ]);
    }
}
