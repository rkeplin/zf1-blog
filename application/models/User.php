<?php
class Model_User extends Keplin_Model_Abstract
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

}