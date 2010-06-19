<?php
class Service_Contact extends Keplin_Service_Abstract
{
    protected $_form;
    
    public function send($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $contact_mapper = new Model_Mapper_Contact();
            $contact = new Model_Contact($data);
            $contact_mapper->send($contact);
            
            $form->clear();
            $this->_message('contact');
        }
        else
        {
            $this->_message('form_errors');
        }
    }
    
    public function getForm()
    {
        if(null === $this->_form)
        {
            $this->_form = new Form_Contact();
        }
        
        return $this->_form;
    }
}