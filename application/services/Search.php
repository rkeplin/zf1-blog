<?php
class Service_Search
{
    protected $_form;
    protected $_searchResults;
    
    public function findResults($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $page = (isset($data['page'])) ? $data['page'] : 1;
            
            $mapper_post = new Model_Mapper_Post();
            $this->_searchResults = $mapper_post->query($data, $page);    
        }
    }
    
    public function getResults()
    {
        return $this->_searchResults;
    }
    
    public function getForm()
    {
        if(null === $this->_form)
        {
            $this->_form = new Form_Search();
        }
        
        return $this->_form;
    }
}