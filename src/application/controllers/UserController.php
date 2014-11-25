<?php

class UserController extends Zend_Controller_Action
{
    private $userApi;
    
    public function init()
    {
        $this->userApi = new Service_User();
    }
    
    public function readAction()
    {
        $this->view->users = $this->userApi->fetchAll();
    }
    
    public function createAction()
    {
    }
    
    public function updateAction()
    {
        $id = $this->_request->getQuery('id');
        $user = $this->userApi->find($id);
        $this->view->user = $user;
    }
    
    public function deleteAction()
    {
        $id = $this->_request->getQuery('id');
        $user = $this->userApi->find($id);
        if (isset($user)){
            $this->userApi->delete($id);
        }
        /*
        $redirector = $this->_helper->getHelper('Redirector');
        $redirector->setCode(301)
        ->setExit(true)
        ->setGotoRoute(array(), 'userRead');
        */
    }
    
    public function saveAction()
    {
        $id = $this->_request->getPost('id');
        $name = $this->_request->getPost('name');
        $password = $this->_request->getPost('password');
        $user = new Model_User();
        if (isset($id)){
            $user->setId($id);
        }
        $user->setName($name);
        $user->setPassword($password);
        
        $this->userApi->save($user);
        
        $redirector = $this->_helper->getHelper('Redirector');
        $redirector->setCode(301)
            ->setExit(true)
            ->setGotoRoute(array(), 'userRead');        
    }
}