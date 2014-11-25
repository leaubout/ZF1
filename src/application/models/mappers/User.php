<?php

class Model_Mapper_User
{
    private $dbTable;
    
    public function find($id){
        $rowSet = $this->getDbTable()->find($id);
        if (0 == count($rowSet->current())){
            return false;
        }
        return $this->rowToObject($rowSet->current());
    }
    
    public function fetchAll($where = null, $order = null, $count = null, $offset = null){
        $rowSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset);
        $entities = array();
        foreach($rowSet as $row){
            $entities[] = $this->rowToObject($row);
        }
        return $entities;
    }
    
    public function delete($id)
    {
        $row =$this->getDbTable()->find($id)->current();
        if (!$row instanceof Zend_Db_Table_Row_Abstract){
            return false;
        }
        return $row->delete();
    }    
    
    public function save($user)
    {
        $row = $this->objectToRow($user);
        if ((int) $user->getId() === 0){
            unset($row['user_id']);
            $this->getDbTable()->insert($row);
        }else{
            $where = array('user_id' => $user->getId());
            $this->getDbTable()->update($row, $where);
        }
    }
    
    public function getDbTable(){
        if ($this->dbTable === null){
            $this->dbTable = new Model_DbTable_User();
        }
        return $this->dbTable;
    }
    
    public function objectToRow($user){
        return array(
          'user_id' => $user->getId(),
          'user_name' => $user->getName(),
          'user_password' => $user->getPassword()
        );
    }
    
    public function rowToObject($row){
        $user = new Model_User; 
        $user->setId($row['user_id']);
        $user->setName($row['user_name']);
        $user->setPassword($row['user_password']);
        return $user;
    }
    
}