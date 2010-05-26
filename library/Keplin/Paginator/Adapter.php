<?php
class Keplin_Paginator_Adapter implements Zend_Paginator_Adapter_Interface
{
    protected $_collection_name;
    protected $_adapter;
    
    public function __construct($collection_name, Zend_Db_Select $select)
    {
        if(!class_exists($collection_name))
        {
            throw new Exception('The class '. $collection_name .' does not exist.');
        }
        
        $this->_collection_name = $collection_name;
        $this->_adapter = new Zend_Paginator_Adapter_DbSelect($select);
    }
    
    public function count()
    {
        return $this->_adapter->count();
    }
    
    public function getItems($offset, $itemCountPerPage)
    {
        $items = $this->_adapter->getItems($offset, $itemCountPerPage);
        $collection = new $this->_collection_name($items);
        
        return $collection;
    }
}