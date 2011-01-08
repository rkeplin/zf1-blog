<?php
namespace Blog\Entity;

abstract class Base
{
    public function __get($key)
    {
        $method = 'get' . self::_normalizeKey($key);

        if(!method_exists($this, $method))
        {
            throw new \Exception('Variable "' . $key . '" does not exist.');
        }

        return $this->$method();
    }

    protected static function _normalizeKey($key)
    {
        $option = str_replace('_', ' ', strtolower($key));
        $option = str_replace(' ', '', ucwords($option));
        return $option;
    }

    public function toArray()
    {
        $array = array();

        foreach($this as $field => $value)
        {
            if($this->$field && !is_object($this->$field))
                $array[$field] = $value;
        }

        return $array;
    }
}