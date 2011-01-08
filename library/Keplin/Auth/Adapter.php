<?php
class Keplin_Auth_Adapter implements Zend_Auth_Adapter_Interface
{
    protected $_user;
    protected $_service;
    
    public function __construct(Blog\Entity\User $user, Service_User $service)
    {
        $this->_user = $user;
        $this->_service = $service;
    }
    
    public function authenticate()
    {
        $user = $this->_service->authenticate($this->_user);

        if(is_object($user->getRole()))
        {
            $result = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $user);
        }
        else
        {
            $result = new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null);
        }
        
        return $result;
    }
}