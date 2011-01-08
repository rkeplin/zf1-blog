<?php
class Service_Post extends Keplin_Service_Acl
{
    protected $_form;
    protected $_repository;

    public function __construct()
    {
        $this->_repository = $this->getEntityManager()->getRepository('Blog\Entity\Post');
    }
    
    public function create($data = array())
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $category = $this->getEntityManager()->find('\Blog\Entity\Category', $data['category_id']);

            if($data['new_category'])
            {
                $category->setId(null);
                $category->setName($data['new_category']);
                $this->getEntityManager()->persist($category);
                
                $this->_form->category_id->addMultiOption($category->id, $category->name);
            }
        
            $post = new \Blog\Entity\Post();
            $post->setContent($data['content']);
            $post->setTitle($data['title']);
            $post->setDateAdded(new DateTime("now"));
            $post->setDateModified(new DateTime("now"));
            $post->setCategory($category);
            $post->setIsPublished($data['is_published']);

            $user = $this->getEntityManager()->find('\Blog\Entity\User', Zend_Auth::getInstance()->getIdentity()->getId());
            $post->setUser($user);
            
            $this->getEntityManager()->persist($post);
            
            $form->clear();
            $this->_message('post_create');
        }
    }
    
    public function update($data = array())
    {
        $form = $this->getForm();
        
        if($form->isValid($data))
        {
            $category = $this->getEntityManager()->find('\Blog\Entity\Category', $data['category_id']);
            
            if($data['new_category'])
            {
                $category->setId(null);
                $category->setName($data['new_category']);
                $this->getEntityManager()->persist($category);
                
                $this->_form->category_id->addMultiOption($category->id, $category->name);
                $this->_form->category_id->setValue($category->id);
                $this->_form->new_category->setValue('');
            }
            
            $post = $this->getEntityManager()->find('\Blog\Entity\Post', $data['id']);
            $post->setContent($data['content']);
            $post->setTitle($data['title']);
            $post->setDateAdded(new DateTime("now"));
            $post->setCategory($category);
            $post->setIsPublished($data['is_published']);
            
            $user = $this->getEntityManager()->find('\Blog\Entity\User', Zend_Auth::getInstance()->getIdentity()->getId());
            $post->setUser($user);

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
                $post = $this->_repository->getPost($post_id);
                
                $this->_form = new Form_Post();
                $this->_form->setSubmitLabel('Update Post');
                $this->_form->populate($post->toArray());
                $this->_form->content->setValue($post->content);
                $this->_form->category_id->setValue($post->category->getId());
            }
        }
        
        return $this->_form;
    }
    
    public function getPaged($page = 1)
    {
        $posts = $this->_repository->getPaged($page);
        
        return $posts;
    }
    
    public function getFromTitle($title)
    {
        $post = $this->_repository->getFromTitle($title);
        
        return $post;
    }
    
    public function getPagedFromCategory($category, $page = 1)
    {
        $posts = $this->_repository->getFromCategory($category, $page);
        
        return $posts;
    }
    
    public function getLatest()
    {
        $post = $this->_repository->getLatest();
        
        return $post;
    }

    public function getRecent($limit = 5)
    {
        $post = $this->_repository->getRecent($limit);

        return $post;
    }

    public function getValidYears()
    {
        $years = $this->_repository->fetchValidYears();

        return $years;
    }
    
    public function getRss()
    {
        $posts = $this->_repository->getRss();
        
        return $posts;
    }
    
    public function getArchive($year, $page = 1)
    {
        $posts = $this->_repository->getFromArchive($year, $page);
        
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
                ->deny(\Blog\Entity\Role::GUEST, $this, array('create', 'edit', 'view-list'));
        }
        
        $this->_acl = $acl;
    }
    
    public function getResourceId()
    {
        return 'post';
    }
}