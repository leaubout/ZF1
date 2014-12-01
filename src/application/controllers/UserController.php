<?php

class UserController extends Zend_Controller_Action
{
    private $userApi;
    
    public function init()
    {
        $this->flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->userApi = new Service_User();
        $this->view->messages = $this->flashMessenger->getMessages();
    }
    
    public function listAction()
    {
        $this->view->headTitle("Liste des utilisateurs");
        $this->view->users = $this->userApi->fetchAll();
    }
    
    public function addAction()
    {
        $form = new Form_User_Add();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $user = new Model_User();
                $user->setName($form->getValue('name'));
                $user->setPassword($form->getValue('pass'));
                if ($this->userApi->save($user)) {
                    $this->flashMessenger->addMessage('Utilisateur créé');
                    //$this->redirect($this->view->url(array(),'userList'));
                    $redirector = $this->_helper->getHelper('Redirector');
                    $redirector->setCode(302)
                        ->setExit(true)
                        ->setGotoRoute(array(), 'userList');
                } else {
                    $this->flashMessenger->addMessage('La création a échoué :');
                }
            }
        }
        $this->view->form = $form;        
    }
    
    public function editAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $user = $this->userApi->find($id);
        
        if (!$user) {
            $this->flashMessenger->addMessage('Utilisateur inexistant');
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->setCode(302)
            ->setExit(true)
            ->setGotoRoute(array(), 'userList');
        }
        
        $form = new Form_User_Edit();
        
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            foreach($data as $key=>$value){
                if (empty($value)){
                    $data[$key] = null;
                }
            }
            if ($form->isValidPartial($data)) {
                //$user récupéré ci-dessus
                $user->setName($form->getValue('name'));
                if ($form->getValue('pass') !== null){
                    $user->setPassword($form->getValue('pass'));
                }
                if ($this->userApi->save($user)) {
                    $this->flashMessenger->addMessage('Utilisateur créé');
                    $redirector = $this->_helper->getHelper('Redirector');
                    $redirector->setCode(302)
                    ->setExit(true)
                    ->setGotoRoute(array(), 'userList');
                } else {
                    $this->flashMessenger->addMessage('La création a échoué :');
                }                
            }
        } else {
            $form->populate(array(
                'id' => $user->getId(),
                'name' => $user->getName(),
                'pass' => $user->getPassword()
            ));
        }
        $this->view->form = $form;
    }
    
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        if ($this->userApi->delete($id)) {
            $this->flashMessenger->addMessage('Utilisateur supprimé');
        } else {
            $this->flashMessenger->addMessage('La suppression a échoué');
        }
        $redirector = $this->_helper->getHelper('Redirector');
        $redirector->setCode(302)
        ->setExit(true)
        ->setGotoRoute(array(), 'userList');
    }
    
}