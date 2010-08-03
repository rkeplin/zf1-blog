<?php
class Service_Search
{
    protected $_form;
    protected $_searchResults;
    protected $_mapper;
    
    public function __construct()
    {
        $this->setMapper(new Model_Mapper_Cache_Post());
    }
    
    public function findPost($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $page = (isset($data['page'])) ? $data['page'] : 1;
            $this->_searchResults = $this->_mapper->query($data, $page);    
        }
    }
    
    public function setMapper(Model_Mapper_PostInterface $mapper)
    {
        $this->_mapper = $mapper;
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