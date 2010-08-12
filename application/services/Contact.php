<?php
class Service_Contact extends Keplin_Service_Abstract
{
    protected $_form;
    protected $_mapper;
    
    public function __construct()
    {
        $this->setMapper(new Model_Mapper_Contact());
    }
    
    public function send($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $contact = new Model_Contact($data);
            $this->_mapper->send($contact);
            
            $form->clear();
            $this->_message('contact');
        }
        else
        {
            $this->_message('form_errors');
        }
    }
    
    public function setMapper(Model_Mapper_Contact $mapper)
    {
        $this->_mapper = $mapper;
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