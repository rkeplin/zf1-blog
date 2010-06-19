<?php

class Form_Contact extends Keplin_Form_Abstract
{
    public function init()
    {
        $this->setMethod('post')->setName('contact_form');
        
        $this->addElement('text', 'name', array(
            'label' => 'Name',
            'required' => true 
        ));
        
        $this->addElement('text', 'email', array(
            'label' => 'Email',
            'required' => true 
        ));
        $this->addElement('text', 'email', array(
            'label' => 'Email',
            'required' => true 
        ));
        $this->email->addValidator('EmailAddress');
        
        $this->addElement('text', 'website', array(
            'label' => 'Website',
            'required' => false
        ));
        $this->website->addValidator('Regex', false, array('pattern' => '/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/', 'messages' => array('regexNotMatch' => 'This website is invalid. Make sure you include the http://')));
        
        $this->addElement('textarea', 'comment', array(
            'label' => 'Comment',
            'attribs' => array(
                'rows' => 8,
                'cols' => 70
            ),
            'required' => true 
        ));
        
        if(APPLICATION_ENV != 'testing')
        {
            $this->addElement('captcha', 'captcha', array(
                'label' => '',
                'captcha' => array(
                    'captcha' => 'dumb',
                    'wordLen' => 4
                )
            ));
        }
        
        $this->addElement('submit', 'send', array(
            'label' => 'Send'
        ));
    }
}