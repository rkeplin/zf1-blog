<?php
class Keplin_Auth_Adapter implements Zend_Auth_Adapter_Interface
{
    protected $_user;
    
    public function __construct(Model_User $user)
    {
        $this->_user = $user;
    }
    
    public function authenticate()
    {
        $user = $this->_user;
        
        $mapper = Keplin_Model_Mapper_Factory::create('User');
        $mapper->login($user);
        
        if($user->id)
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