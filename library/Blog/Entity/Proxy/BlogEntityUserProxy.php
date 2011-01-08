<?php

namespace Blog\Entity\Proxy;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class BlogEntityUserProxy extends \Blog\Entity\User implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    private function _load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function setId($id)
    {
        $this->_load();
        return parent::setId($id);
    }

    public function getId()
    {
        $this->_load();
        return parent::getId();
    }

    public function setName($name)
    {
        $this->_load();
        return parent::setName($name);
    }

    public function getName()
    {
        $this->_load();
        return parent::getName();
    }

    public function setEmail($email)
    {
        $this->_load();
        return parent::setEmail($email);
    }

    public function getEmail()
    {
        $this->_load();
        return parent::getEmail();
    }

    public function setPassword($password)
    {
        $this->_load();
        return parent::setPassword($password);
    }

    public function getPassword()
    {
        $this->_load();
        return parent::getPassword();
    }

    public function setRole($role)
    {
        $this->_load();
        return parent::setRole($role);
    }

    public function getRole()
    {
        $this->_load();
        return parent::getRole();
    }

    public function getRoleId()
    {
        $this->_load();
        return parent::getRoleId();
    }

    public function __get($key)
    {
        $this->_load();
        return parent::__get($key);
    }

    public function toArray()
    {
        $this->_load();
        return parent::toArray();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'name', 'email', 'password', 'role');
    }
}