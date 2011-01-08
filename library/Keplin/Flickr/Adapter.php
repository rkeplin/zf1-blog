<?php
class Keplin_Flickr_Adapter implements Zend_Paginator_Adapter_Interface
{
    protected $_collection; //Model_Flickr_PhotoCollection
    protected $_total_items;
    
    public function __construct($collection = array(), $total_items = 0)
    {
        $this->_collection = $collection;
        $this->_total_items = $total_items;
    }
    
    public function count()
    {
        return $this->_total_items;
    }
    
    public function getItems($offset, $itemCountPerPage)
    {
        return $this->_collection;
    }
}