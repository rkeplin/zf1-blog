<?php

class Zend_View_Helper_Archive extends Zend_View_Helper_Abstract
{
    public function archive()
    {
        $service = new Service_Post();
        $years = $service->getValidYears();
        
        $string = '';
        
        for($year = $years['min_year']; $year <= $years['max_year']; $year++)
        {
            $string .= '<li><a title="'. $year .'" href="/blog/archive/'. $year .'/">'. $year .'</a></li>';
        }
        
        return $string;
    }
}