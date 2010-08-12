<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        $view->setHelperPath(APPLICATION_PATH . '/views/helpers');
    }
    
    protected function _initMapper()
    {
        $this->bootstrap('db');
        Keplin_Model_Mapper_Abstract::setDefaultDb($this->getPluginResource('db')->getDbAdapter());
    }
    
    public function _initProfiler()
    {
        if(APPLICATION_ENV == 'development')
        {
            $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
            $profiler->setEnabled(true);
            
            $db = Keplin_Model_Mapper_Abstract::getDefaultDb();
            $db->setProfiler($profiler);   
        }
    }
    
    public function _initMailer()
    {
        Keplin_Mail::setOptions($this->getOption('mail'));
    }
    
    public function _initCache()
    {
        $front = array(
            'lifetime' => 2678400,
            'automatic_serialization' => true
        );
        
        $flickr_front = array(
            'lifetime' => 86400,
            'automatic_serialization' => true
        );
        
        $back = array(
            'cache_dir' => APPLICATION_PATH . '/../data'
        );
        
        $cache = Zend_Cache::factory('Core', 'File', $front, $back);
        $flickr_cache = Zend_Cache::factory('Core', 'File', $flickr_front, $back);
        
        Zend_Registry::set('cache', $cache);
        Zend_Registry::set('flickr_cache', $flickr_cache);
    }
}