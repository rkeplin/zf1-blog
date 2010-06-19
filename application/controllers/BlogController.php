<?php
class BlogController extends Zend_Controller_Action
{
    public function categoriesAction(){}
    
    public function categoryAction()
    {
        $mapper_post = new Model_Mapper_Post();
        $posts = $mapper_post->getFromCategory($this->_request->getParam('category'), $this->_request->getParam('page'));
        
        $this->view->category = $this->_request->getParam('category');
        $this->view->posts = $posts;
    }
    
    public function rssAction()
    {
        $this->_helper->layout->disableLayout();
        
        $mapper_post = new Model_Mapper_Cache_Post();
        $posts = $mapper_post->getRssFeed();
        
        $this->view->posts = $posts;
    }
    
    public function archivesAction()
    {
        $mapper_post = new Model_Mapper_Cache_Post();
        $years = $mapper_post->fetchValidYears();
        
        $this->view->years = $years;
    }
        
    public function archiveAction()
    {
        $mapper_post = new Model_Mapper_Post();
        $posts = $mapper_post->getFromArchive($this->_request->getParam('year'), $this->_request->getParam('page'));
        
        $this->view->year = $this->_request->getParam('year');
        $this->view->posts = $posts;
    }
    
    public function searchHandlerAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();     
    }
    
    public function searchAction()
    {
        $service = new Service_Search();
        
        $service->findResults($this->_request->getParams());   
        $this->view->posts = $service->getResults();
        
        $this->view->form = $service->getForm();
    }
    
    public function viewAction()
    {
        $mapper_post = new Model_Mapper_Cache_Post();
        $mapper_post->is_published = 0;
        $post = $mapper_post->getFromTitle($this->_request->getParam('title'));
        
        $service = new Service_Comment();
        $service->post_id = $post->id;
        
        if($data = $this->_request->getPost())
        {
            $service->makeComment($data, $post);
        }
        
        $this->view->post = $post;
        $this->view->message = $service->getMessage();
        $this->view->form = $service->getForm();
    }
}