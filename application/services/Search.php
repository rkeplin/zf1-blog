<?php
class Service_Search extends Keplin_Service_Abstract
{
    protected $_form;
    protected $_searchResults;
    
    public function __construct()
    {
        $this->enableCache();
    }
    
    public function findPost($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $page = (isset($data['page'])) ? $data['page'] : 1;
            
            $mapper = Keplin_Model_Mapper_Factory::create('Post', $this->_enable_caching);
            $this->_searchResults = $mapper->query($data, $page);
        }
    }

    public function getForm()
    {
        if(null === $this->_form)
        {
            $this->_form = new Form_Search();
        }
        
        return $this->_form;
    }
    
    public function getResults()
    {
        return $this->_searchResults;
    }
}