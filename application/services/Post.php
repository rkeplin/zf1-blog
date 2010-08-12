<?php
class Service_Post extends Keplin_Service_Abstract
{
    protected $_form;
    protected $_category_mapper;
    protected $_post_mapper;
    
    public function __construct()
    {
        $this->setCategoryMapper(new Model_Mapper_Category());
        $this->setPostMapper(new Model_Mapper_Cache_Post());
    }
    
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
                $category = $this->_category_mapper->save($category);
                
                $form->category_id->addMultiOption($category->name, $category->id);
            }
        
            $post = new Model_Post($data);
            $post->date_added = date("Y-m-d H:i:s");
            $post->category = $category;
            $post->user = Zend_Auth::getInstance()->getIdentity();
            $this->_post_mapper->save($post);
            
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
                $category = $this->_category_mapper->save($category);
                
                $this->_form->category_id->addMultiOption($category->id, $category->name);
                $this->_form->category_id->setValue($category->id);
                $this->_form->new_category->setValue('');
            }
            
            $post = new Model_Post($data);
            $post->date_modified = date("Y-m-d H:i:s");
            $post->category = $category;
            $post->user = Zend_Auth::getInstance()->getIdentity();
            
            $this->_post_mapper->save($post);
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
                $this->_post_mapper->is_published = 0;
                $this->_form = new Form_Post();
                $this->_form->setSubmitLabel('Update Post');
                $post = $this->_post_mapper->getPost($post_id);
                $this->_form->populate($post->toArray());
                $this->_form->content->setValue($post->content);
            }
        }
        
        return $this->_form;
    }
    
    public function getPaged($page = 1)
    {
        $this->_post_mapper->is_published = 0;
        $posts = $this->_post_mapper->getPagedTitles($page);
        
        return $posts;
    }
    
    public function getFromTitle($title)
    {
        $this->_post_mapper->is_published = 0;
        $post = $this->_post_mapper->getFromTitle($title);
        
        return $post;
    }
    
    public function getPagedFromCategory($category, $page = 1)
    {
        $this->_post_mapper->is_published = 1;
        $posts = $this->_post_mapper->getFromCategory($category, $page);
        
        return $posts;
    }
    
    public function getLatest()
    {
        $this->_post_mapper->is_published = 1;
        $post = $this->_post_mapper->fetchLatest();
        
        return $post;
    }
    
    public function getRss()
    {
        $this->_post_mapper->is_published = 1;
        $posts = $this->_post_mapper->getRssFeed();
        
        return $posts;
    }
    
    public function getValidYears()
    {
        $this->_post_mapper->is_published = 1;
        $years = $this->_post_mapper->fetchValidYears();
        
        return $years;
    }
    
    public function getArchive($year, $page = 1)
    {
        $this->_post_mapper->is_published = 1;
        $posts = $this->_post_mapper->getFromArchive($year, $page);
        
        return $posts;
    }
    
    public function setPostMapper(Keplin_Model_Mapper_Abstract $mapper)
    {
        $this->_post_mapper = $mapper;
    }
    
    public function setCategoryMapper(Keplin_Model_Mapper_Abstract $mapper)
    {
        $this->_category_mapper = $mapper;
    }
}