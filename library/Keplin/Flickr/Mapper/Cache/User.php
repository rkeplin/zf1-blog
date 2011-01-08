<?php
class Keplin_Flickr_Mapper_Cache_User extends Keplin_Flickr_Mapper_User
{
    protected $_cache = null;

    public function __construct()
    {
        parent::__construct();

        $this->_cache = Zend_Registry::get('flickr_cache');
    }

    public function fetchOne($username)
    {
        $cache_id = md5('flickr' . '_' . $username);

        if(!($data = $this->_cache->load($cache_id)))
        {
            $data = parent::fetchOne($username);
            $this->_cache->save($data, $cache_id, array('flickr'));
        }

        return $data;
    }
}