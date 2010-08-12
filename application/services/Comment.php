<?php
class Service_Comment 
    extends Keplin_Service_Abstract
        implements SplSubject
{
    protected $_form;
    protected $_comment;
    protected $_post;
    protected $_mapper;
    protected $_observers;    
    
    public function __construct(Model_Post $post)
    {
        $this->_post = $post;
        $this->setMapper(new Model_Mapper_Cache_Comment());
    }
    
    public function create($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $comment = new Model_Comment($data);
            $comment->comment = nl2br($comment->comment);
            $comment->parent_id = $data['parent_id'];
            $comment->ip_address = $_SERVER['REMOTE_ADDR'];
            $comment->post_id = $this->_post->id;
            $comment->status = 0;
            $comment->date_added = date("Y-m-d H:i:s");
            $this->setComment($comment);
            $this->_mapper->save($comment);
            
            $this->notify();
            $form->clear();
            $this->_message('comment');
        }
        else
        {
            $this->_message('form_errors');
        }
    }
    
    public function setMapper(Keplin_Model_Mapper_Abstract $mapper)
    {
        $this->_mapper = $mapper;
    }
    
    public function getForm()
    {
        if(null === $this->_form)
        {
            $this->_form = new Form_Comment();
            $this->_form->setComments($this->_post->id);
        }
        
        return $this->_form;
    }
    
    public function setPost(Model_Post $post)
    {
        $this->_post = $post;
    }
    
    public function getPost()
    {
        return $this->_post;
    }
    
    public function setComment(Model_Comment $comment)
    {
        $this->_comment = $comment;
    }
    
    public function getComment()
    {
        return $this->_comment;
    }
    
    public function attach(SplObserver $observer)
    {
        $id = spl_object_hash($observer);
        $this->_observers[$id] = $observer;
    }
    
    public function detach(SplObserver $observer)
    {
        $id = spl_object_hash($observer);
        unset($this->_observers[$id]);
    }
    
    public function notify()
    {
        foreach($this->_observers as $observer)
        {
            $observer->update($this);
        }
    }        
}