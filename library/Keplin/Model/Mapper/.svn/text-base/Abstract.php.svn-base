<?php
abstract class Keplin_Model_Mapper_Abstract
{
    protected static $_defaultDb;
    protected $_db;
    
    public function __construct(Zend_Db_Adapter_Abstract $db = null)
    {
        if(null === $db)
        {
            $db = self::getDefaultDb();
        }
        
        if(null === $db)
        {
            throw new Exception('No DB adapter was defined!');
        }
        
        $this->_db = $db;
    }
    
    public static function setDefaultDb(Zend_Db_Adapter_Abstract $db)
    {
        self::$_defaultDb = $db;
    }
    
    public static function getDefaultDb()
    {
        return self::$_defaultDb;
    }
}