<?php
class Service_Comment extends Keplin_Service_Abstract
{
    protected $_post_id;
    protected $_form;
    
    public function __construct($post_id)
    {
        $this->_post_id = $post_id;
    }
    
    public function create($data, Model_Post $post)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $mapper_comment = new Model_Mapper_Cache_Comment();
            $mailer = new Keplin_Mail();
            
            if(isset($data['parent_id']) && $data['parent_id'])
            {
                $parent_comment = $mapper_comment->getComment($data['parent_id']);
                $parent_id = ($parent_comment->parent_id != 0) ? $parent_comment->parent_id : $parent_comment->id;
                $mailer->notifyCommenter($parent_comment, $post);
            }
            else
            {
                $parent_id = 0;
            }

            $comment = new Model_Comment($data);
            $comment->comment = nl2br($comment->comment);
            $comment->parent_id = $parent_id;
            $comment->ip_address = $_SERVER['REMOTE_ADDR'];
            $comment->post_id = $this->_post_id;
            $comment->status = 0;
            $comment->date_added = date("Y-m-d H:i:s");
            $mapper_comment->save($comment);
            $mailer->notifyAuthor($comment, $post);
            
            $form->clear();
            $this->_message('comment');
        }
        else
        {
            $this->_message('form_errors');
        }
    }
    
    public function getForm()
    {
        if(null === $this->_form)
        {
            $this->_form = new Form_Comment();
            $this->_form->setComments($this->_post_id);
        }
        
        return $this->_form;
    }
    
    public function setPostId($post_id)
    {
        $this->_post_id = $post_id;
    }
    
    public function getPostId()
    {
        return $this->_post_id;
    }
}