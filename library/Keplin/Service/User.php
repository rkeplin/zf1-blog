<?php
abstract class Keplin_Service_User extends Keplin_Service_Abstract
{
    protected $_current_user;
    
    public function setCurrentUser(Blog\Entity\User $user)
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
                $user = new Blog\Entity\User();
                $user->setRole(Blog\Entity\Role::GUEST);
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