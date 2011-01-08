<?php

class Zend_View_Helper_Categories extends Zend_View_Helper_Abstract
{
    public function categories($name = null)
    {       
        $service = new Service_Category();
        $categories = $service->fetchAll();
        
        $string = '';
        foreach($categories as $category)
        {
            
            if($name == $category->name)
            {
                $class = 'class="selected"';    
            }
            else
            {
                $class = '';
            }
            
            $string .= '<li><a '. $class .' title="'. $category->name .'" href="/blog/category/'. urlencode($category->name) .'/">'. $category->name . '</a></li>';
        }
        
        return $string;
    }
}