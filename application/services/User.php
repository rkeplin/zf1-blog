<?php
class Service_User extends Keplin_Service_User
{
    protected $_form;
    protected $_repository;

    public function __construct()
    {
        $this->_repository = $this->getEntityManager()->getRepository('Blog\Entity\User');
    }
    
    public function login($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $user = new Blog\Entity\User();
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            
            $auth_adapter = new Keplin_Auth_Adapter($user, $this);
            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($auth_adapter);

            if($result->isValid())
            {
                $auth->getIdentity()->getRole()->getId();
                return true;
            }
            
            $this->_message('invalid_pass');
            return false;
            
        }
        
        return false;
    }

    public function authenticate(Blog\Entity\User $user)
    {
        $user = $this->_repository->auth($user);
        
        return $user;
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