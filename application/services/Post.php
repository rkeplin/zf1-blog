<?php

class Service_Post
{
    protected $_form;
    protected $_user;
    protected $_message;
    
    public function __construct()
    {
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
    }
    
    public function create($post)
    {
        $form = $this->getForm();
        
        if($form->isValid($post))
        {
            $category = new Model_Category();
            $category->id = $post['category_id'];
            
            if($post['new_category'])
            {
                $category->id = null;
                $category->name = $post['new_category'];
                
                $mapper_category = new Model_Mapper_Category();
                $category = $mapper_category->save($category);
                
                $form->category_id->addMultiOption($category->name, $category->id);
            }
            
            $post = new Model_Post($post);
            $post->date_added = date("Y-m-d H:i:s");
            $post->category = $category;
            $post->user = $this->_user;
            
            $mapper_post = new Model_Mapper_Cache_Post();
            $mapper_post->save($post);
            
            $form->clear();
            
            $this->_message = 'Successfully created post!';
        }
    }
    
    public function update($post)
    {
        $form = $this->getForm();
        
        if($form->isValid($post))
        {
            $category = new Model_Category();
            $category->id = $post['category_id'];
            
            $session = new Zend_Session_Namespace('robkeplin.com');
            $user = new Model_User($session->user);
            
            if($post['new_category'])
            {
                $category->id = null;
                $category->name = $post['new_category'];
                
                $mapper_category = new Model_Mapper_Category();
                $category = $mapper_category->save($category);
                
                $this->_form->category_id->addMultiOption($category->id, $category->name);
                $this->_form->category_id->setValue($category->id);
                $this->_form->new_category->setValue('');
            }
            
            $post = new Model_Post($post);
            $post->date_modified = date("Y-m-d H:i:s");
            $post->category = $category;
            $post->user = $this->_user;
            
            $mapper = new Model_Mapper_Cache_Post();
            $mapper->save($post);
            
            $this->_message = 'Successfully updated post!';
        }
    }
    
    public function getMessage()
    {
        return $this->_message;
    }

    public function getForm($id = null)
    {
        if(null === $this->_form)
        {
            if(null === $id)
            {
                $this->_form = new Form_Post();
            }
            else
            {
                $mapper_post = new Model_Mapper_Post();
                $mapper_post->is_published = 0;
                
                $this->_form = new Form_Post();
                $this->_form->setSubmitLabel('Update Post');
                $post = $mapper_post->getPost($id);
                $this->_form->populate($post->toArray());

                $this->_form->content->setValue($post->content);
            }
        }
        
        return $this->_form;
    }
}