<?php
class Service_Post extends Keplin_Service_Abstract
{
    protected $_form;
    
    public function create($data = array())
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $category = new Model_Category();
            $category->id = $data['category_id'];
            
            if($data['new_category'])
            {
                $category->id = null;
                $category->name = $data['new_category'];
                
                $mapper_category = new Model_Mapper_Category();
                $category = $mapper_category->save($category);
                
                $form->category_id->addMultiOption($category->name, $category->id);
            }
        
            $post = new Model_Post($data);
            $post->date_added = date("Y-m-d H:i:s");
            $post->category = $category;
            $post->user = Zend_Auth::getInstance()->getIdentity();
            
            $mapper_post = new Model_Mapper_Cache_Post();
            $mapper_post->save($post);
            
            $form->clear();
            $this->_message('post_create');
        }
    }
    
    public function update($data = array())
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $category = new Model_Category();
            $category->id = $data['category_id'];
            
            $session = new Zend_Session_Namespace('robkeplin.com');
            $user = new Model_User($session->user);
            
            if($data['new_category'])
            {
                $category->id = null;
                $category->name = $data['new_category'];
                
                $mapper_category = new Model_Mapper_Category();
                $category = $mapper_category->save($category);
                
                $this->_form->category_id->addMultiOption($category->id, $category->name);
                $this->_form->category_id->setValue($category->id);
                $this->_form->new_category->setValue('');
            }
            
            $post = new Model_Post($data);
            $post->date_modified = date("Y-m-d H:i:s");
            $post->category = $category;
            $post->user = Zend_Auth::getInstance()->getIdentity();
            
            $mapper = new Model_Mapper_Cache_Post();
            $mapper->save($post);
            $this->_message('post_update');
        }
    }
    
    public function getForm($post_id = null)
    {
        if(null === $this->_form)
        {
            if(null === $post_id)
            {
                $this->_form = new Form_Post();
            }
            else
            {
                $mapper_post = new Model_Mapper_Post();
                $mapper_post->is_published = 0;
                
                $this->_form = new Form_Post();
                $this->_form->setSubmitLabel('Update Post');
                $post = $mapper_post->getPost($post_id);
                $this->_form->populate($post->toArray());

                $this->_form->content->setValue($post->content);
            }
        }
        
        return $this->_form;
    }
    
    public function getPaged($page = 1)
    {
        $mapper_post = new Model_Mapper_Post();
        $mapper_post->is_published = 0;
        $posts = $mapper_post->getPagedTitles($page);
        
        return $posts;
    }
    
    public function getFromTitle($title)
    {
        $mapper_post = new Model_Mapper_Cache_Post();
        $mapper_post->is_published = 0;
        $post = $mapper_post->getFromTitle($title);
        
        return $post;
    }
    
    public function getPagedFromCategory($category, $page = 1)
    {
        $mapper_post = new Model_Mapper_Post();
        $posts = $mapper_post->getFromCategory($category, $page);
        
        return $posts;
    }
    
    public function getLatest()
    {
        $mapper_post = new Model_Mapper_Cache_Post();
        $post = $mapper_post->fetchLatest();
        
        return $post;
    }
    
    public function getRss()
    {
        $mapper_post = new Model_Mapper_Cache_Post();
        $posts = $mapper_post->getRssFeed();
        
        return $posts;
    }
    
    public function getValidYears()
    {
        $mapper_post = new Model_Mapper_Cache_Post();
        $years = $mapper_post->fetchValidYears();
        
        return $years;
    }
    
    public function getArchive($year, $page = 1)
    {
        $mapper_post = new Model_Mapper_Post();
        $posts = $mapper_post->getFromArchive($year, $page);
        
        return $posts;
    }
}