<?php

class Service_User
{    
    private $userMapper;
    
    public function getUserMapper()
    {
        if (null === $this->userMapper){
            $this->userMapper = new Model_Mapper_User();
        }
        return $this->userMapper;
    }

    public function find($id)
    {
        $cache = Zend_Controller_Front::getInstance()
                    ->getParam('bootstrap')
                    ->getResource('cachemanager')
                    ->getCache('data1');
        if (!$user = $cache->load('user' . $id)){
            var_dump('pas cache');
            $user = $this->getUserMapper()->find($id);
        }
        return $user;
    }
    
    public function fetchAll($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->getUserMapper()->fetchAll($where, $order, $count, $offset);
    }
    
    public function delete($id)
    {
        return $this->getUserMapper()->delete($id);
    }
    
    public function save($user){
        return $this->getUserMapper()->save($user);
    }
    
}