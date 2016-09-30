<?php
namespace App\Frontend\Modules\Shop;

use \Core\BackController;
use \Core\HTTPRequest;
use Core\Tools;
use Entity\Shop\Cart;
use Entity\Shop\Checkout;
use FormBuilder\Shop\CheckoutFormBuilder;
use Core\Mailer;

/**
 * Class ShopController
 *
 * Classe qui représente le controlleur du module Shop.
 * Comprend plusieurs méthodes correspondant aux différentes routes accessibles et configurées dans
 * le fichier routes.xml
 *
 * Hérite de BackController, qui sert de base à tous les Controllers de l'application
 *
 * @package App\Frontend\Modules\Shop
 */
class ShopController extends BackController
{
    /**
     * Méthode gérant l'affichage de la page d'accueil de la boutique
     *
     * @param HTTPRequest $request La requête et tous ses paramètres
     */
    public function indexAction(HTTPRequest $request)
    {
        $nbLastGames = $this->getApp()->getConfig()->get('nb_last_games');
        
        try {
            $manager = $this->managers->getManagerOf('Game');
            $allGames = $manager->getAllGames($nbLastGames);
            $mostSoldGames = $manager->getMostSold($nbLastGames);
        } catch (\InvalidArgumentException $e) {
            $this->getApp()->getHttpResponse()->redirect404($e->getMessage());
        }
        
        /* Définition des variables de la page */
        $this->page->addVars([
            'pageTitle' => $this->app->getTranslator()->get('core.page_title.shop_home'),
            'pageActive' => 'shop',
            'allGames'   => $allGames,
            'mostSoldGames'   => $mostSoldGames,
            'loadJs' => array('shop.js'),
            'loadCss' => array('shop.css'),
        ]);
    }
    
    /**
     * Méthode gérant l'affichage de la page "tous les jeux
     *
     * @param HTTPRequest $request
     */
    public function allAction(HTTPRequest $request)
    {
        try {
            $games = $this->managers->getManagerOf('Game')->getAllGames();
            $genres = $this->managers->getManagerOf('Genre')->getAllGenres();
            $platforms = $this->managers->getManagerOf('Platform')->getAllPlatforms();
        } catch (\InvalidArgumentException $e) {
            $this->getApp()->getHttpResponse()->redirect404($e->getMessage());
        }
    
        $this->page->addVars([
            'pageTitle' => $this->app->getTranslator()->get('core.page_title.all_games'),
            'pageActive' => 'shop',
            'allGames'   => $games,
            'genres' => $genres,
            'platforms' => $platforms,
            'loadJs' => array('shop.js'),
            'loadCss' => array('shop.css'),
        ]);
    }

    /**
     * Gestion de l'affichage de la page du panier
     *
     * @param HTTPRequest $request
     */
    public function showCartAction(HTTPRequest $request)
    {
        $cart = new Cart();
        //$member = $this->app->getMember();

        $this->page->addVars([
            'pageTitle'  => $this->app->getTranslator()->get('core.page_title.cart'),
            'pageActive' => 'shop',
            'cart' => $cart,
            //'member' => $member,
            'loadJs' => array('shop.js'),
            'loadCss' => array('shop.css'),
        ]);
    }
    
    /**
     * Ajout d'un produit dans le panier, via AJAX
     *
     * @param HTTPRequest $request
     */
    public function addToCartAction(HTTPRequest $request)
    {
        if ($request->isXHR()) {
            $idGame = $request->getPost('idGame');
            $idPlatform = $request->getPost('idPlatform');

            $cart = new Cart();
            $game = $this->managers->getManagerOf('Game')->getGame($idGame);
            $platform = $this->managers->getManagerOf('Platform')->getPlatform($idPlatform);

            $game->setOrderedPlatform($platform);
            $add = $cart->add($game);

            echo json_encode(array(
                'addingOK' => $add,
                'cartProducts' => $cart->getNbProducts(),
                'gameInfos' => array(
                    'idGame' => $game->getId(),
                    'title' => $game->getTitle(),
                    'price' => $game->getPrice(),
                    'jacket' => ROOTADDRESS.'/resources/img/games/'.$game->getJacket(),
                    'cartTotal' => $cart->getTotal(),
                ),
                'platform' => array(
                    'name' => $platform->getShortName(),
                    'id' => $platform->getId(),
                ),
            ));
        }
    }
    
    /**
     * Vide le panier complètement (via AJAX)
     *
     * @param HTTPRequest $request
     */
    public function emptyCartAction(HTTPRequest $request)
    {
        if ($request->isXHR()) {
            $cart = new Cart();
            $cart->emptyCart();
        }
    }
    
    /**
     * Supprime un élément du panier (requête AJAX)
     *
     * @param HTTPRequest $request
     */
    public function removeItemAction(HTTPRequest $request)
    {
        if ($request->isXHR()) {
            $idGame = $request->getPost('idGame');
            $idPlatform = $request->getPost('idPlatform');

            $cart = new Cart();
            $game = $this->managers->getManagerOf('Game')->getGame($idGame);
            $platform = $this->managers->getManagerOf('Platform')->getPlatform($idPlatform);

            $game->setOrderedPlatform($platform);
            $cart->remove($game);

            echo json_encode(array(
                'cartProducts' => $cart->getNbProducts(),
                'cartPrice' => $cart->getTotal(),
            ));
        }
    }

    public function beforeCheckoutAction(HTTPRequest $request)
    {
        $this->page->addVars([
            'pageTitle'  => $this->app->getTranslator()->get('core.page_title.before_checkout'),
            'pageActive' => 'shop',
            'loadJs' => array('shop.js'),
            'loadCss' => array('shop.css'),
        ]);
    }
    
    public function checkoutAction(HTTPRequest $request)
    {
        $translator = $this->app->getTranslator();
        $member = $this->app->getMember();
        $cart = new Cart();

        if (!$member->isAuthenticated()) {
            $this->app->getHttpResponse()->addFlashes('danger', $translator->get('shop.cart_redirect.checkout_mandatory'));
            $this->app->getHttpResponse()->redirect(ROOTADDRESS.'/'.$translator->getLocale().'/shop/before-checkout');
        }
    
        if ($cart->getNbProducts() < 1) {
            $this->app->getHttpResponse()->addFlashes('danger', $translator->get('shop.checkout_redirect.empty_cart'));
            $this->app->getHttpResponse()->redirect(ROOTADDRESS.'/'.$translator->getLocale().'/shop');
        }

        if ($request->getMethod() === 'POST') {
            $checkout = new Checkout([
                'firstname'      => $request->getPost('firstname'),
                'lastname'       => $request->getPost('lastname'),
                'email' => $request->getPost('email'),
                'phone' => $request->getPost('phone'),
                'billingStreet' => $request->getPost('billingStreet'),
                'billingCity' => $request->getPost('billingCity'),
                'billingPostalCode' => $request->getPost('billingPostalCode'),
                'sameAsBilling' => $request->getPost('sameAsBilling'),
            ]);

            if ($checkout->getSameAsBilling()) {
                $checkout->setMailingStreet($checkout->getBillingStreet());
                $checkout->setMailingCity($checkout->getBillingCity());
                $checkout->setMailingPostalCode($checkout->getBillingPostalCode());
            } else {
                $checkout->setMailingStreet($request->getPost('mailingStreet'));
                $checkout->setMailingCity($request->getPost('mailingCity'));
                $checkout->setMailingPostalCode($request->getPost('mailingPostalCode'));
            }
        } else {
            $checkout = new Checkout([
                'firstname' => $member->getFirstname(),
                'lastname' => $member->getLastname(),
                'email' => $member->getEmail(),
                'phone' => $member->getPhone(),
                'billingStreet' => $member->getBillingAddress()->getStreet(),
                'billingPostalCode' => $member->getBillingAddress()->getPostalCode(),
                'billingCity' => $member->getBillingAddress()->getCity(),
                'mailingStreet' => $member->getMailingAddress()->getStreet(),
                'mailingPostalCode' => $member->getMailingAddress()->getPostalCode(),
                'mailingCity' => $member->getMailingAddress()->getCity(),
            ]);
        }
    
        $formBuilder = new CheckoutFormBuilder($checkout, $this->getApp());
        $formBuilder->build();
        $form = $formBuilder->getForm();

        if ($request->getMethod() === 'POST' && $form->isValid()) {
            $this->app->setSession('checkout', $checkout);
            $this->app->getHttpResponse()->addFlashes('success', 'checkout OK');
            $this->app->getHttpResponse()->redirect(ROOTADDRESS.'/'.$this->app->getTranslator()->getLocale().'/shop/payment');
        }
    
        $this->page->addVars([
            'pageTitle'  => $this->app->getTranslator()->get('core.page_title.checkout'),
            'pageActive' => 'shop',
            'cart' => $cart,
            'checkoutForm' => $form->createView(),
            'loadJs' => array('checkout.js'),
            'loadCss' => array('shop.css'),
        ]);
    }
    
    public function paymentAction(HTTPRequest $request)
    {
        $cart = new Cart();
        $checkout = $this->app->getSession('checkout');

        $this->page->addVars([
            'pageTitle'  => $this->app->getTranslator()->get('core.page_title.payment'),
            'pageActive' => 'shop',
            'cart' => $cart,
            'checkout' => $checkout,
        ]);
    }
    
    public function checkoutCompleteAction(HTTPRequest $request)
    {
        $cart = new Cart();
        $member = $this->app->getMember();

        
        /***** MISE A JOUR BDD *****/
        $orderManager = $this->managers->getManagerOf('Order');
        $orderManager->save($cart, $member);

        // mise à jour des données du membres
        $member = $this->managers->getManagerOf('Member')->getMemberById($member->getId());
        $this->app->setMember($member);


        /***** SUPPRESSION PANIER *****/
        $cart->emptyCart();


        /***** ENVOI MAIL *****/

        $fromName = $this->app->getConfig()->get('sendMailFromName');
        $fromEmail = $this->app->getConfig()->get('sendMailFromEmail');
        $mailer = new Mailer($fromName, $fromEmail);

        ob_start();
        include __DIR__.'/Views/pdf_bill.php';
        $content = ob_get_clean();
        $mailer->loadContent($content);

        if ($mailer->sendMail('arnaud.thibaudet@gmail.com', 'Votre facture sur Ifogames')) {
            $this->app->getHttpResponse()->addFlashes('success', 'mail envoyé');
        }


        $this->page->addVars([
            'pageTitle'  => $this->app->getTranslator()->get('core.page_title.checkout_complete'),
            'pageActive' => 'shop',
        ]);
    }
    
    public function gameDetailsAction(HTTPRequest $request)
    {
        if ($request->isXHR()) {
            $idGame = (int)$request->getPost('id');
            $game = $this->managers->getManagerOf('Game')->getGame($idGame);
            
            ob_start();
            include __DIR__.'/Views/game_details.php';
            $body = ob_get_clean();
            
            $title = $this->app->getTranslator()->get('modal.game_details.title', $game->getTitle());
            
            $response = array(
                'title' => $title,
                'body' => $body,
            );
            
            echo json_encode($response);
        }
    }

    public function searchAction(HTTPRequest $request)
    {
        $search = $request->getPost('search');
        $search = Tools::cleanString($search);

        $manager = $this->managers->getManagerOf('Game');

        $games = $manager->searchGame($search);

        $this->page->addVars([
            'pageActive' => 'shop',
            'loadJs' => array('shop.js'),
            'loadCss' => array('shop.css'),
            'search' => $search,
            'games' => $games,
        ]);
    }
}
