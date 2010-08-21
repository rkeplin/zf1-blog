<?php
class BlogController extends Zend_Controller_Action
{
    public function categoriesAction(){}
    
    public function categoryAction()
    {
        $service = new Service_Post();
        $posts = $service->getPagedFromCategory($this->_request->getParam('category'), $this->_request->getParam('page'));
        
        $this->view->category = $this->_request->getParam('category');
        $this->view->posts = $posts;
    }
    
    public function rssAction()
    {
        $this->_helper->layout->disableLayout();
        
        $service = new Service_Post();
        $posts = $service->getRss();
        
        $this->view->posts = $posts;
    }
    
    public function archivesAction()
    {
        $service = new Service_Post();
        $years = $service->getValidYears();
        
        $this->view->years = $years;
    }
        
    public function archiveAction()
    {
        $service = new Service_Post();
        $posts = $service->getArchive($this->_request->getParam('year'), $this->_request->getParam('page'));
        
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
        $service->findPost($this->_request->getParams());
        
        $this->view->posts = $service->getResults();
        $this->view->form = $service->getForm();
    }
    
    public function viewAction()
    {
        $service = new Service_Post();
        $post = $service->getFromTitle($this->_request->getParam('title'));
        $edit_link = $service->getEditLink($post->id);

        $service = new Service_Comment();
        $service->setPost($post);
        $service->attach(new Keplin_Mail_Author());
        $service->attach(new Keplin_Mail_Commenter());
        $service->attach(new Keplin_Mail_Comment());

        if($data = $this->_request->getPost())
        {
            $service->create($data);
        }
        
        $this->view->post = $post;
        $this->view->message = $service->getMessage();
        $this->view->form = $service->getForm();
        $this->view->edit_link = $edit_link;
    }
}