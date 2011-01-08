<?php
class Service_Search extends Keplin_Service_Abstract
{
    protected $_form;
    protected $_searchResults;
    protected $_repository;

    public function __construct()
    {
        $this->_repository = $this->getEntityManager()->getRepository('Blog\Entity\Post');
    }

    public function findPost($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $page = (isset($data['page'])) ? $data['page'] : 1;

            $this->_searchResults = $this->_repository->search($data, $page);
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