<?php
class Keplin_Acl extends Zend_Acl
{
    public function __construct()
    {
        $this->addRole(\Blog\Entity\Role::GUEST)
             ->addRole(\Blog\Entity\Role::ADMIN);
        
        $this->allow();
    }
}