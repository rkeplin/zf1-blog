<?php
class Model_Comment extends Keplin_Model_Abstract
{
    public $id;
    public $parent_id;
    public $post_id;
    public $email;
    public $name;
    public $comment;
    public $date_added;
    public $status;
    public $website;
    public $ip_address;
    public $comments; //Model_CommentsCollection
    
    public function setComment($value)
    {
        $this->comment = strip_tags($value, '<br>');
    }
    
    public function setEmail($value)
    {
        $this->email = strip_tags($value);
    }
    
    public function setName($value)
    {
        $this->name = strip_tags($value);
    }

}