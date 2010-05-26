<?php
class Service_Contact
{
    protected $_form;
    protected $_message;
    
    public function send($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $contact_mapper = new Model_Mapper_Contact();
            $contact = new Model_Contact($data);
            $contact_mapper->send($contact);
            
            $form->clear();
            
            $this->_message = 'Successfully sent mail to Rob!';
        }
        else
        {
            $this->_message = 'Please fix the errors detailed on the contact form below.';
        }
    }
    
    public function getMessage()
    {
        return $this->_message;
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