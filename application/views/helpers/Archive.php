<?php

class Zend_View_Helper_Archive extends Zend_View_Helper_Abstract
{
    public function archive()
    {
        $mapper = new Model_Mapper_Cache_Post();
        $years = $mapper->fetchValidYears();
        
        $string = '';
        
        for($year = $years['min_year']; $year <= $years['max_year']; $year++)
        {
            $string .= '<li><a title="'. $year .'" href="/blog/archive/'. $year .'/">'. $year .'</a></li>';
        }
        
        return $string;
    }
}