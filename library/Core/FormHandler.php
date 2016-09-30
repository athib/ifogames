<?php
namespace Core;

use FormBuilder\Form;

/**
 * Class FormHandler
 * Permet de gérer un formulaire, s'il a été posté
 * Permet de déporter le code pour décharger les controlleurs
 *
 * @package Core
 */
class FormHandler
{
    /************************* PROPRIETES *************************/
    
    protected $form;
    protected $manager;
    protected $request;
    
    
    
    /************************* CONSTRUCTEUR *************************/
    
    /**
     * FormHandler constructor.
     *
     * @param Form $form Le formulaire à traier
     * @param Manager $manager Le manager de l'entité correspondant au formulaire
     * @param HTTPRequest $request La requête, pour accéder aux informations postées
     */
    public function __construct(Form $form, Manager $manager, HTTPRequest $request)
    {
        $this->setForm($form);
        $this->setManager($manager);
        $this->setRequest($request);
    }
    
    
    /************************* METHODES *************************/
    
    /**
     * Traitement du formulaire
     * On vérifie que la requête est en POST, puis si le formulaire est valide
     * Dans ce cas, on sauvegarder l'entité en base de données
     *
     * @return bool On retourne un booléen indiquant si le traitement du formulaire a réussi ou non
     */
    public function process()
    {
        if ($this->request->getMethod() === 'POST' && $this->form->isValid()) {
            $this->manager->save($this->form->getEntity());
            
            return true;
        }
        
        return false;
    }
    
    
    /************************* SETTERS *************************/
    
    public function setForm(Form $form)
    {
        $this->form = $form;
        
        return $this;
    }
    
    public function setManager(Manager $manager)
    {
        $this->manager = $manager;
        
        return $this;
    }
    
    public function setRequest(HTTPRequest $request)
    {
        $this->request = $request;
        
        return $this;
    }
}
