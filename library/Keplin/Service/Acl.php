<?php
abstract class Keplin_Service_Acl extends Keplin_Service_User implements Zend_Acl_Resource_Interface
{
    protected $_acl;
    
    abstract public function setAcl(Zend_Acl $acl);
    
    public function getAcl()
    {
        if(null === $this->_acl)
        {
            $this->setAcl(new Keplin_Acl());
        }
        
        return $this->_acl;
    }
    
    public function checkAcl($action)
    {
        return $this->getAcl()->isAllowed($this->getCurrentUser(), $this, $action);
    }
}