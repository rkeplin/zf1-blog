<?php
class Service_Category extends Keplin_Service_Abstract
{
    protected $_repository;

    public function __construct()
    {
        $this->_repository = $this->getEntityManager()->getRepository('Blog\Entity\Category');
    }

    public function fetchAll()
    {
        $categories = $this->_repository->fetchAll();

        return $categories;
    }
}