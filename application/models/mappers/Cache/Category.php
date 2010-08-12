<?php
class Model_Mapper_Cache_Category 
    extends Model_Mapper_Category
{
    protected $_cache = null;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_cache = Zend_Registry::get('cache');   
    }
    
    public function save(Model_Category $category)
    {
        parent::save($category);
        $this->_cache->clean('all', array('post'));
    }
    
    public function fetchAll($is_published = 1)
    {
        $cache_id = md5('all_categories' . '_' . $is_published);
        
        if(!($data = $this->_cache->load($cache_id)))
        {
            $data = parent::fetchAll($is_published);
            $this->_cache->save($data, $cache_id, array('post'));
        }
        
        return $data;
    }
}