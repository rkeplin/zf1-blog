<?php
class Model_User extends Keplin_Model_Abstract implements Zend_Acl_Role_Interface
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $role_id;
    
    public function __construct($options = null)
    {
        parent::__construct($options);
    }
    
    public function setPassword($value)
    {
        $this->password = md5($value);
    }
    
    public function getRoleId()
    {
        if(!$this->role_id)
            $this->role_id = Model_Role::GUEST;
            
        return $this->role_id;
    }
}