<?php
class Service_Flickr extends Keplin_Service_Abstract
{
    protected $_page;
    protected $_per_page;
    
    public function __construct()
    {
        $this->enableCache();
        $this->setPerPage(24);
    }
    
    public function fetchPhotosFromUsername($username)
    {
        $user = $this->fetchUser($username);
        $photos = $this->fetchPhotosFromUser($user);
        
        return $photos;
    }
    
    public function fetchUser($username)
    {
        $mapper = Keplin_Flickr_Mapper_Factory::create('User', $this->_enable_caching);
        $user = $mapper->fetchOne('rkeplin');
        
        return $user;
    }
    
    public function fetchPhotosFromUser(Model_Flickr_User $user)
    {
        $mapper = Keplin_Flickr_Mapper_Factory::create('Photo', $this->_enable_caching);
        $photos = $mapper->fetchPaged($user, $this->_page, $this->_per_page);
        
        return $photos;
    }
    
    public function setPage($page)
    {
        $this->_page = $page;
    }
    
    public function getPage()
    {
        return $this->_page;
    }
    
    public function setPerPage($per_page)
    {
        $this->_per_page = $per_page;
    }
    
    public function getPerPage()
    {
        return $this->_per_page;
    }
}