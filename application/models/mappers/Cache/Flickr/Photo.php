<?php
class Model_Mapper_Cache_Flickr_Photo extends Model_Mapper_Flickr_Photo
{
    protected $_cache = null;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_cache = Zend_Registry::get('flickr_cache');   
    }
    
    public function fetchPaged(Model_Flickr_User $user, $page = 1, $per_page = 25, $sort = 'date-taken-desc')
    {
        $cache_id = md5('flickr' . '_' . $user->username . '_' . $page . '_' . $per_page . '_' . 'date-taken-desc');
        
        if(!($data = $this->_cache->load($cache_id)))
        {
            $data = parent::fetchPaged($user, $page, $per_page, $sort);
            $this->_cache->save($data, $cache_id, array('flickr'));
        }
        
        return $data;
    }
}