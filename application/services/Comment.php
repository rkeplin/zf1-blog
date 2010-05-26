<?php
class Service_Comment
{
    public $post_id;
    protected $_form;
    protected $_message;
    
    public function makeComment($data, Model_Post $post)
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
                
                $mailer->sendCommentResponse($parent_comment, $post);
            }
            else
            {
                $parent_id = 0;
            }

            $comment = new Model_Comment($data);
            $comment->comment = nl2br($comment->comment);
            $comment->parent_id = $parent_id;
            $comment->ip_address = $_SERVER['REMOTE_ADDR'];
            $comment->post_id = $this->post_id;
            $comment->status = 0;
            $comment->date_added = date("Y-m-d H:i:s");
            
            $mapper_comment->save($comment);
            
            $mailer->sendRobComment($comment, $post);
            
            $form->clear();
            
            $this->_message = 'Successfully added comment!';
        }
        else
        {
            $this->_message = 'Please fix the errors below, detailed on the comment form.';
        }
    }
    
    public function getMessage()
    {
        return $this->_message;
    }
    
    public function getForm()
    {
        if(null === $this->_form)
        {
            $this->_form = new Form_Comment();
            $this->_form->setComments($this->post_id);
        }
        
        return $this->_form;
    }
}