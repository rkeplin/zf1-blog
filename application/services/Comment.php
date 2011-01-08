<?php
class Service_Comment 
    extends Keplin_Service_Acl
        implements SplSubject
{
    protected $_form;
    protected $_comment;
    protected $_post;
    protected $_observers;    
    protected $_repository;

    public function __construct()
    {
        $this->_repository = $this->getEntityManager()->getRepository('Blog\Entity\Comment');
    }
    
    public function create($data)
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $comment = new \Blog\Entity\Comment();
            $comment->setComment(nl2br($data['comment']));
            $comment->setParentId($data['parent_id']);
            $comment->setIpAddress($_SERVER['REMOTE_ADDR']);
            $comment->setPost($this->_post);
            $comment->setStatus(0);
            $comment->setDateAdded(new DateTime("now"));
            $comment->setName($data['name']);
            $comment->setEmail($data['email']);
            $comment->setWebsite($data['website']);

            $this->getEntityManager()->persist($comment);

            $this->_comment = $comment;
            
            $this->notify();
            $form->clear();
            $this->_message('comment');
        }
        else
        {
            $this->_message('form_errors');
        }
    }
    
    public function fetchPaged($page)
    {
        $comments = $this->_repository->fetchPaged($page);
        
        return $comments;
    }
    
    public function delete($comment_id)
    {
        $this->_repository->delete($comment_id);
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
    
    public function setPost(Blog\Entity\Post $post)
    {
        $this->_post = $post;
    }
    
    public function getPost()
    {
        return $this->_post;
    }
    
    public function setComment(Blog\Entity\Comment $comment)
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
    
    public function getResourceId()
    {
        return 'comment';
    }
    
    public function setAcl(Zend_Acl $acl)
    {
        if(!$acl->has($this->getResourceId()))
        {
            $acl->add($this)
                ->deny(\Blog\Entity\Role::GUEST, $this, array('view-paged', 'delete'));
        }
        
        $this->_acl = $acl;
    }
}