<?php
class Service_User
{
    protected $_form;
    protected $_message = null;
    
    public function login($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $user = new Model_User($data);
            $user_mapper = new Model_Mapper_User();
            
            $auth_adapter = new Keplin_Auth_Adapter($user);
            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($auth_adapter);
            
            if(!$result->isValid())
            {
                $this->_message = 'The credentials entered were incorrect.';
                return false;
            }

            return true;
            
        }
        
        return false;
    }
    
    public function logout()
    {
        Zend_Auth::getInstance()->clearIdentity();
    }
    
    public function getMessage()
    {
        return $this->_message;
    }
    
    public function getForm()
    {
        if(null === $this->_form)
        {
            $this->_form = new Form_Login();
        }
        
        return $this->_form;
    }
}