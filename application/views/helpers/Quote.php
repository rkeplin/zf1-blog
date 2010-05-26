<?php

class Zend_View_Helper_Quote extends Zend_View_Helper_Abstract
{
    public function quote()
    {
        $mapper = new Model_Mapper_Quote();
        $quote = $mapper->getQuote();
        
        $string = '<em>';
        $string .= $quote->quote . ' - ' . $quote->author;
        
        if($quote->year)
        {
            $string .= '('. $quote->year .')';
        }
        
        $string .= '</em>';
        
        return $string;
    }
}