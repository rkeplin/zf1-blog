<?php
class Model_Mapper_Cache_Post extends Model_Mapper_Post
{
    protected $_cache = null;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_cache = Zend_Registry::get('cache');
    }
    
    public function getRssFeed()
    {
        $cache_id = 'rss';
        
        if(!($data = $this->_cache->load($cache_id)))
        {
            $data = parent::getRssFeed();
            $this->_cache->save($data, $cache_id, array('post'));
        }
        
        return $data;
    }
    
    public function save(Model_Post $post)
    {
        parent::save($post);
        $this->_cache->clean('all', array('post'));
    }
    
    public function getFromTitle($title)
    {
        $cache_id = md5('post_' . $title);
        
        if(!($data = $this->_cache->load($cache_id)))
        {
            $data = parent::getFromTitle($title);
            $this->_cache->save($data, $cache_id, array('post'));
        }
        
        return $data;
    }
    
    public function fetchLatest()
    {
        $cache_id = 'latest_post';
        
        if(!($data = $this->_cache->load($cache_id)))
        {
            $data = parent::fetchLatest();
            $this->_cache->save($data, $cache_id, array('post'));
        }
        
        return $data;
    }
    
    public function fetchValidYears()
    {
        $cache_id = 'valid_years';
        
        if(!($data = $this->_cache->load($cache_id)))
        {
            $data = parent::fetchValidYears();
            $this->_cache->save($data, $cache_id, array('post'));
        }
        
        return $data;
    }
    
    public function getRecentPosts($limit)
    {
        $cache_id = 'recent_posts';
        
        if(!($data = $this->_cache->load($cache_id)))
        {
            $data = parent::getRecentPosts($limit);
            $this->_cache->save($data, $cache_id, array('post'));
        }
        
        return $data;
    }
}