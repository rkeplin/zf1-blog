<?php
class Keplin_Acl extends Zend_Acl
{
    public function __construct()
    {
        $this->addRole(Model_Role::GUEST)
             ->addRole(Model_Role::ADMIN);
        
        $this->allow();
    }
}