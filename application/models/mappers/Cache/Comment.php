<?php
class Model_Mapper_Cache_Comment extends Model_Mapper_Comment
{
    protected $_cache = null;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_cache = Zend_Registry::get('cache');   
    }
    
    public function save(Model_Comment $comment)
    {
        parent::save($comment);
        $this->_cache->clean('all', array('post'));
    }
    
    public function delete($id)
    {
        parent::delete($id);
        $this->_cache->clean('all', array('post'));
    }
}