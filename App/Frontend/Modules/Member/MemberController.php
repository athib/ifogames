<?php
namespace App\Frontend\Modules\Member;

use \Core\BackController;
use Core\FormHandler;
use \Core\HTTPRequest;
use Entity\Address;
use Entity\Member;
use FormBuilder\Member\AddressFormBuilder;
use FormBuilder\Member\LoginMemberFormBuilder;
use FormBuilder\Member\RegisterMemberFormBuilder;
use FormBuilder\Member\MemberFormBuilder;
use Model\MemberManager;

/**
 * Class MemberController
 *
 * Classe qui représente le controlleur du module Member.
 * Comprend plusieurs méthodes correspondant aux différentes interactions avec l'utilisateur
 *
 * Hérite de BackController, qui sert de base à tous les Controllers de l'application
 *
 * @package App\Frontend\Modules\Member
 */
class MemberController extends BackController
{
    /**
     * Méthode gérant la connexion d'un utilisateur
     * Vérifie si l'utilisateur est déjà connecté auquel cas on le redirige
     * Sinon, on vérifie les informations de connexion et on authetifie le membre
     * La méthode gère AJAX, car la requête de connexion vient d'un Modal Bootstrap, cela évite de
     * rafraîchir la page
     *
     * @param HTTPRequest $request La requête et tous ses paramètres
     */
    public function loginAction(HTTPRequest $request)
    {
        // Si l'utilisateur est déjà connecté, on le redirige vers l'accueil
        if ($this->app->hasMember()) {
            $this->app->getHttpResponse()->redirect(ROOTADDRESS.'/'.$this->getApp()->getTranslator()->getLocale().'/');
            exit();
        }
    
        // Si le formulaire a été posté
        if ($request->getMethod() === 'POST') {
            // On créé une nouvelle instance de Member avec les infos postées
            $loggingMember = new Member([
                'username'     => $request->getPost('username'),
                'password'     => $request->getPost('password'),
            ]);
        } else { // Si on est sur un premier affichage de la page (pas encore postée), on créé un Member vide
            $loggingMember = new Member();
        }

        // On génère le formulaire correspondant au membre
        $formBuilder = new LoginMemberFormBuilder($loggingMember, $this->getApp());
        $formBuilder->build();
        $form = $formBuilder->getForm();
    
        // Gestionnaire du formulaire
        //$formHandler = new FormHandler($form, $manager, $request);
        
        // Si le formulaire est valide
        if ($request->getMethod() === 'POST' && $form->isValid()) {
            $manager = $this->managers->getManagerOf('Member');
            $user = $manager->getMember($loggingMember->getUsername());
            
            // Si le membre existe, et que son couple login/password est valide
            if ($user && $loggingMember->getUsername() == $user->getUsername() && password_verify($loggingMember->getPassword(), $user->getPassword())) {
                // update de la date de dernière connexion
                $manager->updateLastLogin($user);
                $user->setAuthenticated(true);
                $_SESSION['member'] = $user;
                
                $this->app->getHttpResponse()->addFlashes(
                    'success',
                    'Vous avez bien été connecté. Bienvenue '.$user->getUsername().' !'
                );
        
                $this->app->getHttpResponse()->redirect(
                    ROOTADDRESS.'/'.$this->getApp()->getTranslator()->getLocale().'/'
                );
                exit();
            } else {
                $this->app->getHttpResponse()->addFlashes(
                    'danger',
                    'Désolé, les informations que vous avez fourni ne sont pas valides.'
                );
            }
        }
        
        $this->page->addVars([
            'pageTitle'      => $this->app->getTranslator()->get('core.page_title.login'),
            'pageActive' => 'login',
            //'newMember' => $loggingMember,
            'formLogin' => $form->createView(),
        ]);
    }
    
    /**
     * Méthode gérant la déconnexion d'un utilisateur
     *
     * La déconnexion est gérée en AJAX
     * On détruit les variables de session
     *
     * @param HTTPRequest $request La requête et tous ses paramètres
     */
    public function logoutAction(HTTPRequest $request)
    {
        unset($_SESSION['member']);
        unset($_SESSION['auth']);
        unset($_SESSION['cart']);
        
        $this->app->getHttpResponse()->addFlashes('success', 'Vous avez été correctement déconnecté. A bientôt !');
        $this->app->getHttpResponse()->redirect(ROOTADDRESS.'/'.$this->getApp()->getTranslator()->getLocale().'/');
    }
    
    /**
     * Méthode qui procède à l'enregistrement d'un membre en base de données
     * On vérifie si le formulaire a été posté, on le valide et on enregistre le compte, sinon on
     * reaffiche le formulaire avec les informations saisies et les messages d'erreur
     *
     * @param HTTPRequest $request
     */
    public function registerAction(HTTPRequest $request)
    {
        $manager = $this->managers->getManagerOf('Member');
        
        // Si le formulaire a été posté
        if ($request->getMethod() === 'POST') {
            // On créé une nouvelle instance de Member avec les infos postées
            $newMember = new Member([
                'username'        => $request->getPost('username'),
                'email'           => $request->getPost('email'),
                'password'        => $request->getPost('password'),
                'passwordConfirm' => $request->getPost('passwordConfirm'),
            ]);
            
            // On vérifie si la confirmation de mdp est valide, sinon on affecte un flag testé plus loin
            if (!$manager->checkPasswordConfirmation($newMember)) {
                $newMember->setPasswordConfirm(MemberManager::PASSWORD_NOT_CONFIRMED);
            }
        } else { // Si on est sur un premier affichage de la page (pas encore postée), on créé un Member vide
            $newMember = new Member();
        }
        
        // On génère le formulaire correspondant au membre
        $formBuilder = new RegisterMemberFormBuilder($newMember, $this->getApp());
        $formBuilder->build();
        $form = $formBuilder->getForm();
        
        // Gestionnaire du formulaire
        $formHandler = new FormHandler($form, $manager, $request);
        
        // Si le formulaire est valide, on enregistre le membre (process() appelle save())
        if ($formHandler->process()) {
            // On informe l'utilisateur et on redirige vers la page de login pour valider l'inscription
            $this->app->getHttpResponse()->addFlashes(
                'success',
                'Votre compte a bien été créé, vous pouvez vous connecter.'
            );
            
            $this->app->getHttpResponse()->redirect(
                ROOTADDRESS.'/'.$this->getApp()->getTranslator()->getLocale().'/login'
            );
        }
        
        
        $this->page->addVars([
            'pageTitle' => $this->app->getTranslator()->get('core.page_title.register'),
            'pageActive' => 'user',
            'newMember'    => $newMember,
            'formRegister' => $form->createView(),
        ]);
    }
    
    public function profileAction(HTTPRequest $request)
    {
        $member = $this->app->getMember();
        
        $this->page->addVars([
            'pageTitle' => $this->app->getTranslator()->get('core.page_title.profile'),
            'pageActive' => 'user',
            'member'    => $member,
            'loadCss'   => array('profile.css'),
            'loadJs'   => array('profile.js'),
        ]);
    }
    
    public function profileEditInfosAction(HTTPRequest $request)
    {
        $currentMember = $this->app->getMember();
        $memberPosted = clone $currentMember;

        if ($request->isXHR() && $request->getPost('action') == 'edit') {
            $formBuilder = new MemberFormBuilder($currentMember, $this->app);
            $formBuilder->build();
            $form = $formBuilder->getForm();
            
            $data = array('html' => $form->createView());
            echo json_encode($data);
            
            return;
        }
    
        if ($request->isXHR() && $request->getPost('action') == 'validate') {
            $memberPosted->setUsername($request->getPost('username'));
            $memberPosted->setFirstname($request->getPost('firstname'));
            $memberPosted->setLastname($request->getPost('lastname'));
            $memberPosted->setEmail($request->getPost('email'));
            $memberPosted->setPhone($request->getPost('phone'));
        
            $formBuilder = new MemberFormBuilder($memberPosted, $this->app);
            $formBuilder->build();
            $form = $formBuilder->getForm();

            if ($form->isValid()) {
                $manager = $this->managers->getManagerOf('Member');

                $res = $manager->checkBeforeUpdate($memberPosted, $currentMember);

                if ($res !== null) {
                    $response = array(
                        'status' => false,
                        'field' => $res,
                        'html' => $form->createView(),
                    );
                    echo json_encode($response);
                    return;
                }

                $manager->save($memberPosted);
                $this->app->setMember($memberPosted);

                $response = array(
                    'status' => true,
                    'userMenu' => $this->app->getTranslator()->get('core.main_menu.welcome', $memberPosted->getUsername()),
                    'member' => array(
                        $this->app->getTranslator()->get('user.profile.username') => $memberPosted->getUsername(),
                        $this->app->getTranslator()->get('user.profile.firstname') => $memberPosted->getFirstname(),
                        $this->app->getTranslator()->get('user.profile.lastname') => $memberPosted->getLastname(),
                        $this->app->getTranslator()->get('user.profile.email') => $memberPosted->getEmail(),
                        $this->app->getTranslator()->get('user.profile.phone') => $memberPosted->getPhone(),
                    ),
                );
                echo json_encode($response);
                
                return;
            }

            $response = array(
                'status' => false,
                'html' => $form->createView(),
            );
            
            echo json_encode($response);
            return;
        }
    }
    
    public function profileEditAddressAction(HTTPRequest $request)
    {
        $member = $this->app->getMember();

        $btnName = $request->getPost('what');
        $matches = array();
        preg_match('#^profile-edit-(.+)-address$#', $btnName, $matches);

        $getter = 'get'.ucfirst($matches[1]).'Address';
        $setter = 'set'.ucfirst($matches[1]).'Address';

        $address = $member->$getter();

        if ($address == null) {
            $address = new Address();
        }

        if ($request->isXHR() && $request->getPost('action') == 'edit') {
            $formBuilder = new AddressFormBuilder($address, $this->app);
            $formBuilder->build();
            $form = $formBuilder->getForm();
        
            $data = array('html' => $form->createView());
            echo json_encode($data);
        
            return;
        }
    
        if ($request->isXHR() && $request->getPost('action') == 'validate') {
            $address->setStreet($request->getPost('street'));
            $address->setPostalCode((int)$request->getPost('postalCode'));
            $address->setCity($request->getPost('city'));

            $formBuilder = new AddressFormBuilder($address, $this->app);
            $formBuilder->build();
            $form = $formBuilder->getForm();

            if ($form->isValid()) {
                $manager = $this->managers->getManagerOf('Address');
                $manager->save($address, $member, $matches[1]);

                $member->$setter($address);
                $this->app->setMember($member);
    
                $response = array(
                    'status' => true,
                    'address' => array(
                        $this->app->getTranslator()->get('user.profile.street') => $address->getStreet(),
                        $this->app->getTranslator()->get('user.profile.postal_code') => $address->getPostalCode(),
                        $this->app->getTranslator()->get('user.profile.city') => $address->getCity(),
                    ),
                );
                
                echo json_encode($response);

                return;
            }

            echo $form->createView();
        }
    }
}
