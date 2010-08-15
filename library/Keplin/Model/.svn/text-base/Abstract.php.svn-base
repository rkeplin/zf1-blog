<?php
abstract class Keplin_Model_Abstract
{
    public function __construct($options = null)
    {
        $this->setOptions($options);
    }
    
    public function setOptions($options)
    {
        
        if(null === $options)
        {
            return;
        }
        
        if(is_object($options) || is_array($options))
        {
            foreach($options as $field => $value)
            {
                $this->_setField($field, $value); 
            }
        }
        else
        {
            throw new Exception('The entity "' . get_class($this) . '" must be created by an array or object.');
        }
    }
    
    protected function _setField($field, $value = null)
    {
        if(!$value)
        {
            return;
        }
            
        if(property_exists(get_class($this), $field))
        {
            //See if there is a setter
            $method = 'set' . ucfirst($field);
            if(method_exists(get_class($this), $method))
            {
                call_user_func(array($this, $method), $value);
                return;
            }
            
            $this->$field = $value;
        }
    }
    
    public function toArray()
    {
        $array = array();
        
        foreach($this as $field => $value)
        {
            if($this->$field && !is_object($this->$field))
                $array[$field] = stripslashes($value);
        }
        
        return $array;
    }
}