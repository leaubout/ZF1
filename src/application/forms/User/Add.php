<?php 

class Form_User_Add extends Zend_Form
{
   public function init()
   {
       $this->setAction('')
            ->setMethod(Zend_Form::METHOD_POST);
       
       $this->addElement('text', 'name', array(
           'label' => 'Nom',
           'placeholder' => 'ex: toto'
       ));
       
       $this->getElement('name')
            ->setRequired(true)
            ->addValidator(new Zend_Validate_Alnum())
            ->setOrder(1);

       $this->addElement('text', 'email', array(
           'label' => 'Email',
           'placeholder' => 'ex: toto@hotmail.fr'
       ));
        
       $email =  new Zend_Validate_EmailAddress();
       $email->setMessage('Test', Zend_Validate_EmailAddress::INVALID_HOSTNAME);
       $this->getElement('email')
            //->setErrorMessages(array('true'))
            ->setRequired(true)
            ->addValidator($email)
            ->setOrder(2);
        
       
       $this->addElement('password', 'pass', array(
               'label' => 'Mot de passe'
       ));
       
       $this->getElement('pass')
            ->setRequired(true)
            ->addValidator(
                new Zend_Validate_StringLength(
                     array('min' => 6)
                )
            )
            ->addValidator(new Zend_Validate_Identical('confirmPass'))
            ->setOrder(3);
       
       $this->addElement('password', 'confirmPass', array(
           'label' => 'Confirmation mot de passe',
           'required' => TRUE,
           'order' => 4,
           'validators' => array(new Zend_Validate_Identical('pass'))
       ));
       
       /*$this->getElement('confirmPass')
       ->setOrder(3);*/
       
       $this->addElement('submit', 'send', array(
               'label' => 'Créer',
                'class' => 'btn btn-primary',
                'order' => 5
       ));
   } 
}
