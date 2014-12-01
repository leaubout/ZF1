<?php 

class Form_User_Edit extends Form_User_Add
{
   public function init()
   {
       parent::init();
       
       $this->addElement('hidden', 'id');
       $this->getElement('id')
            ->setRequired(true)
            ->addValidator(new Zend_Validate_Int());
       
     $this->getElement('pass')->setRequired(FALSE);
     $this->getElement('confirmPass')->setRequired(FALSE);
       
   } 
}
