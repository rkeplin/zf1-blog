<?php

class Zend_View_Helper_Quote extends Zend_View_Helper_Abstract
{
    public function quote()
    {
        $service = new Service_Quote();
        $quote = $service->getRandom();
        
        $string = '<em>';
        $string .= $quote->quote . ' - ' . $quote->author;
        
        if($quote->year)
        {
            $string .= ' ('. $quote->year .')';
        }
        
        $string .= '</em>';
        
        return $string;
    }
}