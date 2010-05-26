<?php

class Keplin_Form_Abstract extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        
        $this->addElementPrefixPath('Keplin_Validate', 'Keplin/Validate/', 'validate');
    }
    
    public function clear()
    {
        $values = $this->getValues();
        
        foreach($values as $key => $val)
        {
            $values[$key] = NULL;
        }
        
        $this->populate($values);
    }
}