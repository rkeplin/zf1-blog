<?php
class Service_User extends Keplin_Service_User
{
    protected $_form;
    
    public function login($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $user = new Model_User($data);
            
            $auth_adapter = new Keplin_Auth_Adapter($user);
            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($auth_adapter);
            
            if(!$result->isValid())
            {
                $this->_message('invalid_pass');
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
    
    public function getForm()
    {
        if(null === $this->_form)
        {
            $this->_form = new Form_Login();
        }
        
        return $this->_form;
    }
}