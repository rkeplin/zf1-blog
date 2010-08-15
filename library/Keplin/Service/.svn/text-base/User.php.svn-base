<?php
abstract class Keplin_Service_User extends Keplin_Service_Abstract
{
    protected $_current_user;
    
    public function setCurrentUser(Model_User $user)
    {
        $this->_current_user = $user;
    }
    
    public function getCurrentUser()
    {
        if(null === $this->_current_user)
        {
            $auth = Zend_Auth::getInstance();
            
            if(!$auth->hasIdentity())
            {
                $user = new Model_User();
                $user->role_id = Model_Role::GUEST;
            }
            else
            {
                $user = $auth->getIdentity();
            }
            
            $this->setCurrentUser($user);
        }
        
        return $this->_current_user;
    }
}