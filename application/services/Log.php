<?php
class Service_Log extends Keplin_Service_Acl
{
    protected $_file;
    protected $_form;
    
    public function __construct()
    {
        $this->_file = APPLICATION_PATH . '/../logs/exceptions.log';
    }
    
    public function display()
    {   
        if($this->logExists())
        {
            header('Content-type: text/plain');
            header('Content-Disposition: attachment; filename="exceptions.log"');
            echo file_get_contents($this->_file);   
        }
    }
    
    public function delete()
    {
        if($this->logExists())
        {
            unlink($this->_file);
            $this->_message('delete-log');
        }
    }
    
    public function logExists()
    {
        return file_exists($this->_file);
    }
    
    public function getForm()
    {
        if($this->_form == null)
        {
            $this->_form = new Form_Log();
        }
        
        return $this->_form;
    }
    
    public function setAcl(Zend_Acl $acl)
    {
        if(!$acl->has($this->getResourceId()))
        {
            $acl->add($this)
                ->deny(Model_Role::GUEST, $this, array('view', 'delete'));
        }
        
        $this->_acl = $acl;
    }
    
    public function getResourceId()
    {
        return 'log';
    }
}