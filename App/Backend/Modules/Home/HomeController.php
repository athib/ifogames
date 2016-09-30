<?php
namespace App\Backend\Modules\Home;

use \Core\BackController;
use \Core\HTTPRequest;
use Entity\Shop\Game;
use FormBuilder\Admin\GameFormBuilder;
use FormBuilder\Admin\GenreFormBuilder;
use FormBuilder\Admin\PlatformFormBuilder;

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
    public function indexAction(HTTPRequest $request)
    {
        $this->page->addVars([
            'pageTitle'      => 'Administration du site',
            'pageActive' => 'admin',
            'loadCss' => array('jquery-ui/jquery-ui.min.css', 'tablesorter.css', 'admin.css'),
            'loadJs' => array('jquery-ui.min.js', 'jquery.tablesorter.js', 'admin.js'),
        ]);
    }
    
    public function deleteMemberAction(HTTPRequest $request)
    {
        if ($request->isXHR()) {
            $idMember = $request->getPost('idMember');
            
            $this->managers->getManagerOf('Member')->delete($idMember);
        }
    }

    public function deleteGameAction(HTTPRequest $request)
    {
        if ($request->isXHR()) {
            $idGame = $request->getPost('idGame');

            $this->managers->getManagerOf('Game')->delete($idGame);
        }
    }
    
    
    public function membersListAction(HTTPRequest $request)
    {
        if ($request->isXHR()) {
            $members = $this->managers->getManagerOf('Member')->getAll();
            
            ob_start();
            include __DIR__.'/Views/members_list.php';
            $table = ob_get_clean();
            
            $response = array(
                'table' => $table,
            );
            
            echo json_encode($response);
        }
    }

    public function memberDetailsAction(HTTPRequest $request)
    {
        if ($request->isXHR()) {
            $idMember = (int)$request->getPost('id');
            $member = $this->managers->getManagerOf('Member')->getMemberById($idMember);

            ob_start();
            include __DIR__.'/Views/member_details.php';
            $body = ob_get_clean();

            $title = $this->app->getTranslator()->get('modal.members_details.title', $idMember);

            $response = array(
                'title' => $title,
                'body' => $body,
            );

            echo json_encode($response);
        }
    }

    public function ordersListAction(HTTPRequest $request)
    {
        if ($request->isXHR()) {
            $orders = $this->managers->getManagerOf('Order')->getOrders();
            
            ob_start();
            include __DIR__.'/Views/orders_list.php';
            $table = ob_get_clean();

            $response = array(
                'table' => $table,
            );

            echo json_encode($response);
        }
    }
    
    public function orderDetailsAction(HTTPRequest $request)
    {
        if ($request->isXHR()) {
            $idOrder = (int)$request->getPost('id');
            $order = $this->managers->getManagerOf('Order')->getOrderById($idOrder);
            $customer = $this->managers->getManagerOf('Member')->getMemberById($order->getIdMember());
            
            ob_start();
            include __DIR__.'/Views/order_details.php';
            $body = ob_get_clean();
            
            $title = $this->app->getTranslator()->get('modal.order_details.title', $idOrder);
    
            $response = array(
                'title' => $title,
                'body' => $body,
            );
    
            echo json_encode($response);
        }
    }

    public function gamesListAction(HTTPRequest $request)
    {
        if ($request->isXHR()) {
            $games = $this->managers->getManagerOf('Game')->getAllGames();

            ob_start();
            include __DIR__.'/Views/games_list.php';
            $table = ob_get_clean();

            $response = array(
                'table' => $table,
            );

            echo json_encode($response);
        }
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

    public function gameEditAction(HTTPRequest $request)
    {
        if ($request->isXHR()) {
            $idGame = (int)$request->getPost('id');
            $game = $this->managers->getManagerOf('Game')->getGame($idGame);
    
            ob_start();
            include __DIR__.'/Views/game_edit.php';
            $body = ob_get_clean();
    
            $title = $this->app->getTranslator()->get('modal.game_edit.title');
    
            $response = array(
                'title' => $title,
                'body' => $body,
            );
    
            echo json_encode($response);
        }
    }
    
    public function gameAddAction(HTTPRequest $request)
    {
        $gameManager = $this->managers->getManagerOf('Game');
        $genreManager = $this->managers->getManagerOf('Genre');
        $platformManager = $this->managers->getManagerOf('Platform');
        
        if ($request->isXHR()) {
            $idGame = $request->getPost('id');
            if ($request->getPost('save')) {
                $game = new Game(array(
                    'id' => (int) $idGame,
                    'title' => $request->getPost('title'),
                    'description' => $request->getPost('description'),
                    'idEditor' => $request->getPost('editor'),
                    'releaseDate' => $request->getPost('releaseDate'),
                    'price' => $request->getPost('price'),
                    'pegi' => $request->getPost('pegi'),
                ));
                $listGenres = $request->getPost('myGenres') ? explode(',', $request->getPost('myGenres')) : array();
                $listPlatforms = $request->getPost('myPlatforms') ? explode(',', $request->getPost('myPlatforms')) : array();
                
                $genres = array();
                foreach ($listGenres as $idGenre) {
                    $genres[] = $genreManager->getGenreById($idGenre);
                }
                
                $platforms = array();
                foreach ($listPlatforms as $idPlatform) {
                    $platforms[] = $platformManager->getPlatform($idPlatform);
                }
                
                $game->setGenres($genres);
                $game->setPlatforms($platforms);
            } else {
                $game = new Game();

                if (null != $idGame) {
                    $game = $gameManager->getGame($idGame);
                }
            }
            
            $gameFormBuilder = new GameFormBuilder($game, $this->getApp());
            $gameFormBuilder->build();
            $formGame = $gameFormBuilder->getForm();
            
            $genresFormBuilder = new GenreFormBuilder($game, $this->getApp(), $game->getGenres());
            $genresFormBuilder->build();
            $formGenres = $genresFormBuilder->getForm();

            $platformsFormBuilder = new PlatformFormBuilder($game, $this->getApp(), $game->getPlatforms());
            $platformsFormBuilder->build();
            $formPlatforms = $platformsFormBuilder->getForm();

            if ($request->getPost('save') && $formGame->isValid()) {
                $game = $gameManager->save($game);
                if ($game->isNew() || $request->getFile('jacket')) {
                    $gameManager->savePicture($game->getId(), $game, $request->getFile('jacket'));
                }
                $body = 'ajout ok';
                $adding = true;
            } else {
                $formGame = $formGame->createView();
                $formGenres = $formGenres->createView();
                $formPlatforms = $formPlatforms->createView();
                ob_start();
                include __DIR__.'/Views/game_add.php';
                $body = ob_get_clean();
                $adding = false;
            }
            
            $title = $this->app->getTranslator()->get('modal.game_add.title');
            
            $response = array(
                'adding' => $adding,
                'title' => $title,
                'body' => $body,
            );
            
            echo json_encode($response);
        }
    }
}
