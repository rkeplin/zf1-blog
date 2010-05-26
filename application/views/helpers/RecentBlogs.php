<?php

class Zend_View_Helper_RecentBlogs extends Zend_View_Helper_Abstract
{
    public function recentBlogs($limit = 2)
    {
        $mapper = new Model_Mapper_Cache_Post();
        $posts = $mapper->getRecentPosts($limit);
        
        $string = '';
        
        foreach($posts as $post)
        {
            $string .= '<li><a title="'. $post->title .'" href="/blog/view/'. urlencode($post->category->name) .'/'. urlencode($post->title) .'/">'. $post->title .'</a></li>';
        }
        
        return $string;
    }
}