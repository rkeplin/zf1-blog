<?php
class Keplin_Auth_Adapter 
    implements Zend_Auth_Adapter_Interface
{
    protected $_user;
    protected $_mapper;
    
    public function __construct(Model_User $user)
    {
        $this->_user = $user;
        $this->setMapper(new Model_Mapper_User());
    }
    
    public function authenticate()
    {
        $user = $this->_user;
        $this->_mapper->login($user);
        
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
    
    public function setMapper(Keplin_Model_Mapper_Abstract $mapper)
    {
        $this->_mapper = $mapper;
    }
}