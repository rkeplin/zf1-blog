<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initPluginCache()
    {
        if($this->getEnvironment() == 'production')
        {
            $file = APPLICATION_PATH . '/../data/plugin-cache.php';
            
            if(file_exists($file)) 
            {
                include_once $file;
            }
            
            Zend_Loader_PluginLoader::setIncludeFileCache($file);   
        }
    }
    
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
    protected function _initMapper()
    {
        Keplin_Flickr_Mapper_Abstract::setDefaultOptions($this->getOption('flickr'));
    }
    
    public function _initMailer()
    {
        Keplin_Mail::setOptions($this->getOption('mail'));
    }
    
    public function _initCache()
    {
        $front = array(
            'lifetime' => 36000,
            'automatic_serialization' => true
        );
        
        $back = array(
            'cache_dir' => APPLICATION_PATH . '/../data'
        );
        
        $cache = Zend_Cache::factory('Core', 'File', $front, $back);

        Zend_Registry::set('flickr_cache', $cache);
    }

    public function _initAutoloader()
    {
        require_once APPLICATION_PATH . '/../library/Doctrine/Common/ClassLoader.php';

        $autoloader = \Zend_Loader_Autoloader::getInstance();

        $symfonyAutoloader = new \Doctrine\Common\ClassLoader('Symfony');
        $autoloader->pushAutoloader(array($symfonyAutoloader, 'loadClass'), 'Symfony');

        $doctrineExtensionsAutoloader = new \Doctrine\Common\ClassLoader('DoctrineExtensions');
        $autoloader->pushAutoloader(array($doctrineExtensionsAutoloader, 'loadClass'), 'DoctrineExtensions');

        $doctrineAutoloader = new \Doctrine\Common\ClassLoader('Doctrine');
        $autoloader->pushAutoloader(array($doctrineAutoloader, 'loadClass'), 'Doctrine');

        $doctrineAutoloader = new \Doctrine\Common\ClassLoader('Blog');
        $autoloader->pushAutoloader(array($doctrineAutoloader, 'loadClass'), 'Blog');
    }

    public function _initEntityManager()
    {
        $cache = new \Doctrine\Common\Cache\ArrayCache;
        $config = new \Doctrine\ORM\Configuration;
        $config->setMetadataCacheImpl($cache);
        
        $driverImpl = $config->newDefaultAnnotationDriver(APPLICATION_PATH . '/../library/Blog/Entity');
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir(APPLICATION_PATH . '/../library/Blog/Entity/Proxy');
        $config->setProxyNamespace('Blog\Entity\Proxy');
        $config->setAutoGenerateProxyClasses(true);
        $config->addCustomStringFunction('YEAR', 'Blog\Query\AST\Year');

        $options = $this->getOption('doctrine');
        
        $em = \Doctrine\ORM\EntityManager::create($options['db'], $config);

        Keplin_Service_Abstract::setDefaultEntityManager($em);
        
        return $em;
    }
}