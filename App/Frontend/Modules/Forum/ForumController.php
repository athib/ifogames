<?php

namespace App\Frontend\Modules\Forum;

use \Core\BackController;
use FormBuilder\ForumPostFormBuilder;
use FormBuilder\TextField;
use \Core\HTTPRequest;
use Core\Role;
use \Entity\Forum\ForumPost;
use FormBuilder\Form;

/**
 * Class ForumController
 *
 * Classe qui représente le controlleur du module Forum.
 * Comprend plusieurs méthodes correspondant aux différentes routes accessibles et configurées dans
 * le fichier routes.xml
 *
 * Hérite de BackController, qui sert de base à tous les Controllers de l'application
 *
 * @package App\Frontend\Modules\Forum
 */
class ForumController extends BackController
{
    /**
     * Méthode gérant l'affichage de la page d'accueil du Forum
     * Affichage des catégories et de la liste des rubriques associées
     *
     * @param HTTPRequest $request La requête et tous ses paramètres
     */
    public function indexAction(HTTPRequest $request)
    {
        // On récupère toutes les catégories et leurs sections
        $manager = $this->managers->getManagerOf('ForumCategory');
        $categories = $manager->getCategoriesWithSections();

        /* Ici on définit toutes les variables que l'on fournit à la vue */
        $this->page->addVars([
            'pageTitle'  => 'Accueil du Forum',
            'pageActive' => 'forum',
            'categories'  => $categories,
        ]);
    }

    /**
     * Méthode gérant l'affichage d'une Rubrique (Section)
     * Affiche la liste des discussions de la rubrique passée en paramètre (GET)
     *
     * @param HTTPRequest $request La requête et tous ses paramètres
     */
    public function showSectionAction(HTTPRequest $request)
    {
        // On récupère le nombre de discussion à afficher par page (fichier congig.xml)
        $threadsPerPage = $this->getApp()->getConfig()->get('forum_threads_per_page');

        // on récupère les paramètres GET de l'url : slug de la section à afficher, et page (voir routes.xml)
        $sectionSlug = $request->getGet('section_slug');
        $sectionPage = $request->getGet('page');

        // Si aucune page n'a été passée en paramètre, on la définit par défaut à 1
        if (!$sectionPage) {
            $sectionPage = 1;
        }

        // On récupère la section et ses threads
        // Une exception est levée dans le cas où la section n'existe pas, on l'attrape et redirige vers 404
        try {
            $manager = $this->managers->getManagerOf('ForumSection');
            $section = $manager->getSectionWithThreads($sectionSlug, $sectionPage, $threadsPerPage);
        } catch (\InvalidArgumentException $e) {
            $this->getApp()->getHttpResponse()->redirect404($e->getMessage());
        }

        // Calcul du nombre de pages pour la pagination
        // Si 0 thread, page 0, on ajuste à 1 pour l'affichage
        $nbPages = ceil($section->getNbThreads() / $threadsPerPage);

        if (!$nbPages) {
            $nbPages = 1;
        }

        // Si on demande une page qui n'existe pas, on redirige vers la page d'erreur
        if ($sectionPage > $nbPages) {
            $this->getApp()->getHttpResponse()->redirect404('La page demandée n\'existe pas dans la rubrique.');
        }
    

        $this->page->addVars([
            'pageTitle'          => 'Rubrique du Forum - '.$section->getName(),
            'pageActive'         => 'forum',
            'section'            => $section,
            'sectionCurrentPage' => $sectionPage,
            'sectionNbPages'     => $nbPages,
        ]);
    }
    
    /**
     * Méthode gérant l'affichage d'une Discussion (Thread)
     * Affiche la liste des message de la discussion passée en paramètre (GET)
     *
     * @param HTTPRequest $request La requête et tous ses paramètres
     */
    public function showThreadAction(HTTPRequest $request)
    {
        // On récupère le nombre de messages à afficher par page (fichier congig.xml)
        $postsPerPage = $this->getApp()->getConfig()->get('forum_posts_per_page');
    
        // on récupère les paramètres GET de l'url : slug de la section à afficher, et page (voir routes.xml)
        $threadSlug = $request->getGet('thread_slug');
        $threadPage = $request->getGet('page');
    
        // Si aucune page n'a été passée en paramètre, on la définit par défaut à 1
        if (!$threadPage) {
            $threadPage = 1;
        }
    
        // On récupère le thread et ses posts
        // Une exception est levée dans le cas où le thread n'existe pas, on l'attrape et redirige vers 404
        try {
            $manager = $this->managers->getManagerOf('ForumThread');
            $thread = $manager->getThreadWithPosts($threadSlug, $threadPage, $postsPerPage);
        } catch (\InvalidArgumentException $e) {
            $this->getApp()->getHttpResponse()->redirect404($e->getMessage());
        }

        // Calcul du nombre de pages pour la pagination
        // Si 0 post, page 0, on ajuste à 1 pour l'affichage
        $nbPages = ceil($thread->getNbPosts() / $postsPerPage);
    
        if (!$nbPages) {
            $nbPages = 1;
        }
    
        // Si on demande une page qui n'existe pas, on redirige vers la page d'erreur
        if ($threadPage > $nbPages) {
            $this->getApp()->getHttpResponse()->redirect404('La page demandée n\'existe pas dans la discussion.');
        }
        
        // Si on a posté un message
        if ($request->getMethod() === 'POST') {
            // On génère une entité avec les infos postées
            $userPost = new ForumPost([
                'content' => $request->getPost('content'),
                'createdByIdMember' => (int)$this->app->getMember()->getId(),
                'idThread' => $thread->getId(),
            ]);
        } else { // sinon on crée une entité vide
            $userPost = new ForumPost();
        }

        // Génération du formulaire
        $formBuilder = new ForumPostFormBuilder($userPost, $this->getApp());
        $formBuilder->build();
        $form = $formBuilder->getForm();

        $formHandler = new \Core\FormHandler($form, $this->managers->getManagerOf('ForumPost'), $request);

        if ($formHandler->process()) {
            // On enregistre le Post en base de données
            //$this->managers->getManagerOf('ForumPost')->save($userPost);
            $this->app->getHttpResponse()->addFlashes('success', 'Votre message a bien été posté.');

            // on calcule la page vers laquelle on redirige, puis on execute la redirection
            $go_to_page = $thread->getNbPosts() % $nbPages == 0 ? $nbPages + 1 : $nbPages;
            $this->app->getHttpResponse()->redirect(ROOTADDRESS . '/' . $this->getApp()->getTranslator()->getLocale() . "/forum/discussion/$threadSlug/page-$go_to_page");
        } else {
            //$this->app->getHttpResponse()->addFlashes('danger', 'Erreur dans le formulaire.');
        }
        
        
        $this->page->addVars([
            'pageTitle'         => 'traduireForum - Discussion',
            'pageActive'        => 'forum',
            'thread'            => $thread,
            'threadCurrentPage' => $threadPage,
            'threadNbPages'     => $nbPages,
            'formPost'         => $form->createView()
        ]);
    }

    public function editPostAction(HTTPRequest $request)
    {
        // on récupère les paramètres GET de l'url : slug de la section à afficher, et page (voir routes.xml)
        $threadSlug = $request->getGet('thread_slug');
        $idPost = $request->getGet('id_post');

        $thread = $this->managers->getManagerOf('ForumThread')->getThreadBySlug($threadSlug);
        $manager = $this->managers->getManagerOf('ForumPost');
        $post = $manager->getPostById($idPost);
        $post->setIdThread($thread->getId());

        if ($request->getMethod() === 'POST') {
            $post->setContent($request->getPost('content'));
            $post->setUpdatedByIdMember((int)$this->app->getMember()->getId());
        }

        // Génération du formulaire
        $formBuilder = new ForumPostFormBuilder($post, $this->getApp());
        $formBuilder->build();
        $form = $formBuilder->getForm();


        // Si on a posté et que le formulaire est valide
        if ($request->getMethod() === 'POST' && $form->isValid()) {
            // On enregistre le Post en base de données
            $manager->save($post);
            $this->app->getHttpResponse()->addFlashes('success', 'Le message a bien été modifié.');
            $this->app->getHttpResponse()->redirect(ROOTADDRESS . '/' . $this->getApp()->getTranslator()->getLocale() . "/forum/discussion/$threadSlug");
        }


        $this->page->addVars([
            'post'      => $post,
            'formPost' => $form->createView()
        ]);
    }
}
