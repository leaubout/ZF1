<?php

class IndexController extends Zend_Controller_Action
{
    protected $flashMessenger;
    
    public function init()
    {
        $this->flashMessenger = $this->_helper->getHelper('FlashMessenger');
    }

    public function indexAction()
    {
        $this->view->headTitle("Page d'accueil");
        $this->view->headMeta()->appendName('description','page 1 du site');
        $this->view->headMeta()->appendName('keywords','test, test');
        
        $userApi = new Service_User();
        $this->view->user = $userApi->find(1);
        
    }

    public function testAction(){        
        $this->view->headTitle("Page de test");
        $this->view->messages = $this->flashMessenger->getMessages();
    }

    public function testredirectAction(){
        $this->flashMessenger->addMessage('Redirection effectuée');
        
        $redirector = $this->_helper->getHelper('Redirector');
        $redirector->setCode(301)
                    ->setExit(true)
                    ->setGotoRoute(array(), 'indexTest');
    }    
}

