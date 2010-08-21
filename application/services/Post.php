<?php
class Service_Post extends Keplin_Service_Acl
{
    protected $_form;

    public function __construct()
    {
        $this->enableCache();
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
                
                $mapper = Keplin_Model_Mapper_Factory::create('Category', $this->_enable_caching);
                $category = $mapper->save($category);
                
                $form->category_id->addMultiOption($category->name, $category->id);
            }
        
            $post = new Model_Post($data);
            $post->date_added = date("Y-m-d H:i:s");
            $post->category = $category;
            $post->user = Zend_Auth::getInstance()->getIdentity();
            
            $mapper = Keplin_Model_Mapper_Factory::create('Post', $this->_enable_caching);
            $mapper->save($post);
            
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
                
                $mapper = Keplin_Model_Mapper_Factory::create('Category', $this->_enable_caching);
                $category = $mapper->save($category);
                
                $this->_form->category_id->addMultiOption($category->id, $category->name);
                $this->_form->category_id->setValue($category->id);
                $this->_form->new_category->setValue('');
            }
            
            $post = new Model_Post($data);
            $post->date_modified = date("Y-m-d H:i:s");
            $post->category = $category;
            $post->user = Zend_Auth::getInstance()->getIdentity();
            
            $mapper = Keplin_Model_Mapper_Factory::create('Post', $this->_enable_caching);
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
                $mapper = Keplin_Model_Mapper_Factory::create('Post', $this->_enable_caching);
                $mapper->is_published = 0;
                $post = $mapper->getPost($post_id);
                
                $this->_form = new Form_Post();
                $this->_form->setSubmitLabel('Update Post');
                $this->_form->populate($post->toArray());
                $this->_form->content->setValue($post->content);
            }
        }
        
        return $this->_form;
    }
    
    public function getPaged($page = 1)
    {
        $mapper = Keplin_Model_Mapper_Factory::create('Post', $this->_enable_caching);
        $mapper->is_published = 0;
        $posts = $mapper->getPagedTitles($page);
        
        return $posts;
    }
    
    public function getFromTitle($title)
    {
        $mapper = Keplin_Model_Mapper_Factory::create('Post', $this->_enable_caching);
        $mapper->is_published = 0;
        $post = $mapper->getFromTitle($title);
        
        return $post;
    }
    
    public function getPagedFromCategory($category, $page = 1)
    {
        $mapper = Keplin_Model_Mapper_Factory::create('Post', $this->_enable_caching);
        $mapper->is_published = 1;
        $posts = $mapper->getFromCategory($category, $page);
        
        return $posts;
    }
    
    public function getLatest()
    {
        $mapper = Keplin_Model_Mapper_Factory::create('Post', $this->_enable_caching);
        $mapper->is_published = 1;
        $post = $mapper->fetchLatest();
        
        return $post;
    }
    
    public function getRss()
    {
        $mapper = Keplin_Model_Mapper_Factory::create('Post', $this->_enable_caching);
        $mapper->is_published = 1;
        $posts = $mapper->getRssFeed();
        
        return $posts;
    }
    
    public function getValidYears()
    {
        $mapper = Keplin_Model_Mapper_Factory::create('Post', $this->_enable_caching);
        $mapper->is_published = 1;
        $years = $mapper->fetchValidYears();
        
        return $years;
    }
    
    public function getArchive($year, $page = 1)
    {
        $mapper = Keplin_Model_Mapper_Factory::create('Post', $this->_enable_caching);
        $mapper->is_published = 1;
        $posts = $mapper->getFromArchive($year, $page);
        
        return $posts;
    }
    
    public function getEditLink($post_id)
    {
        if($this->checkAcl('edit'))
        {
            return '<a title="edit" href="/admin/edit-post/id/' . $post_id . '/">edit</a>';   
        }
    }
    
    public function setAcl(Zend_Acl $acl)
    {
        if(!$acl->has($this->getResourceId()))
        {
            $acl->add($this)
                ->deny(Model_Role::GUEST, $this, array('create', 'edit', 'view-list'));
        }
        
        $this->_acl = $acl;
    }
    
    public function getResourceId()
    {
        return 'post';
    }
}