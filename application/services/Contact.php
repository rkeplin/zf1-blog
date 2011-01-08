<?php
class Service_Contact extends Keplin_Service_Abstract
{
    protected $_form;
    
    public function send($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $contact = new \Blog\Entity\Contact();
            $contact->setComment($data['comment']);
            $contact->setEmail($data['email']);
            $contact->setName($data['name']);
            $contact->setWebsite($data['website']);
            
            $mailer = new Keplin_Mail_Contact();
            $mailer->send($contact);
            
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