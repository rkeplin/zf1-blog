<?php
class Model_Post extends Keplin_Model_Abstract
{
    public $id;
    public $title;
    public $content;
    public $date_added;
    public $date_modified;
    public $is_published = 0;
    public $user; //Model_User
    public $category; //Model_Category
    public $comments; //Model_CommentCollection
    
    
    public function setUser(Model_User $user)
    {
        $this->user = $user;
    }
    
    public function setCategory($category)
    {
        if(is_string($category))
        {
            $cat = new Model_Category();
            $cat->name = $category;
        }
        else if(is_object($category))
        {
            $cat = $category;
        }
        else
        {
            throw new Exception('The category must be an object, or a string.');
        }
        
        $this->category = $cat;
    }
    
    public function setComments(Model_CommentsCollection $comments)
    {
        $this->comments = $comments;
    }
    
    public function toArray()
    {
        $array = parent::toArray();
        
        if(isset($this->category->id) && $this->category->id)
        {
            $array['category_id'] = $this->category->id;
        }
        
        if(isset($this->user) && $this->user->id)
        {
            $array['user_id'] = $this->user->id;
        }
        
        if(!$this->is_published)
        {
            $array['is_published'] = 0;
        }
        
        return $array;
    }
    
}