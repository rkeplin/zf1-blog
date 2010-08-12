<?php
class Keplin_Flickr_Adapter implements Zend_Paginator_Adapter_Interface
{
    protected $_collection; //Model_Flickr_PhotoCollection
    protected $_total_items;
    
    public function __construct(Model_Flickr_PhotoCollection $collection, $total_items)
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