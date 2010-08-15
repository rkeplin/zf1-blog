<?php
abstract class Keplin_Model_Collection_Abstract implements Iterator, Countable
{
    protected $_count;
    protected $_resultSet;
    protected $_item_class;
    private $_index;
    
    public function __construct($class, $results)
    {
        if(!class_exists($class))
        {
            throw Exception('The class ' . $class . ' does not exist.');
        }
        
        $this->_item_class = $class;
        $this->_resultSet = $results;
    }
    
    public function toArray()
    {
        return $this->_resultSet;
    }
    
    public function count()
    {
        if(NULL === $this->_count) 
        {
            $this->_count = count($this->_resultSet);
        }
        return $this->_count;
    }

    public function current()
    {   
        $result  = $this->_resultSet[$this->_index];
        
        if(!$result instanceof $this->_item_class) 
        {
            $result  = new $this->_item_class($result);
            $this->_resultSet[$this->_index] = $result;
        }
        
        return $result;
    }
    
    public function getItem($index)
    {
        if($this->_resultSet[$index] instanceof $this->_item_class)
        {
           return $this->_resultSet[$index];
        }
        
        return new $this->_item_class($this->_resultSet[$index]);
    }

    public function key()
    {
        return $this->_index;
    }

    public function next()
    {
        $this->_index++;
    }

    public function rewind()
    {
        $this->_index = 0;
    }

    public function valid()
    {
        return isset($this->_resultSet[$this->_index]);
    }
}