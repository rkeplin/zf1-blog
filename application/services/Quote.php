<?php
class Service_Quote extends Keplin_Service_Abstract
{
    protected $_repository;

    public function __construct()
    {
        $this->_repository = $this->getEntityManager()->getRepository('Blog\Entity\Quote');
    }

    public function getRandom()
    {
        return $this->_repository->getRandom();
    }
}