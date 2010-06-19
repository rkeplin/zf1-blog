<?php

class Form_Login extends Keplin_Form_Abstract
{
    public function init()
    {
        $this->setMethod('post')->setName('login_form');
        
        $this->addElement('text', 'email', array(
            'label' => 'Username',
            'required' => true 
        ));
        
        $this->addElement('password', 'password', array(
            'label' => 'Password',
            'required' => true 
        ));
        
        $this->addElement('submit', 'login', array(
            'label' => 'Login'
        ));
    }
}