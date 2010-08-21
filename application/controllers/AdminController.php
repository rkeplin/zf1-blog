<?php
class AdminController extends Zend_Controller_Action
{   
    public function indexAction()
    {
        $service = new Service_Post();
        
        if(!$service->checkAcl('view-list')) {
            throw new Keplin_ProhibitedException('Viewing Editable Post List: Access Prohibited.');
        }
        
        $posts = $service->getPaged($this->_request->getParam('page'));
        
        $this->view->posts = $posts;
    }
    
    public function loginAction()
    {
        $service = new Service_User();
        
        if($service->getCurrentUser()->role_id == Model_Role::ADMIN)
        {
            $this->_helper->redirector('index');
        }
        
        if($data = $this->_request->getPost())
        {
            if($service->login($data))
            {
                $this->_helper->redirector('index');
            }
        }

        $this->view->message = $service->getMessage();
        $this->view->form = $service->getForm();
    }
    
    public function logoutAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $service = new Service_User();
        $service->logout();
        
        $this->_helper->redirector('index', 'index');
    }
    
    public function createPostAction()
    {
        $service = new Service_Post();
        
        if(!$service->checkAcl('create')) {
            throw new Keplin_ProhibitedException('Creating Posts: Access Prohibited.');
        }
        
        if($this->_request->isPost())
        {
            $service->create($this->_request->getParams());
        }
        
        $this->view->message = $service->getMessage();
        $this->view->form = $service->getForm();
    }
    
    public function commentsAction()
    {
        $service = new Service_Comment();
        
        if(!$service->checkAcl('view-paged')) {
            throw new Keplin_ProhibitedException('Editing Posts: Access Prohibited.');
        }
        
        $this->view->comments = $service->fetchPaged($this->_request->getParam('page'));
    }
    
    public function deleteCommentAction()
    {
        $service = new Service_Comment();
        
        if(!$service->checkAcl('delete')) {
            throw new Keplin_ProhibitedException('Deleting Comments: Access Prohibited.');
        }
        
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $service->delete($this->_request->getParam('id'));
    }
    
    public function editPostAction()
    {
        $service = new Service_Post();
        
        if(!$service->checkAcl('edit')) {
            throw new Keplin_ProhibitedException('Editing Posts: Access Prohibited.');
        }
        
        $form = $service->getForm($this->_request->getParam('id'));
        
        if($this->_request->isPost())
        {
            $service->update($this->_request->getParams());
        }
        
        $this->view->message = $service->getMessage();
        $this->view->form = $form;
    }
    
    public function downloadLogAction()
    {
        $service = new Service_Log();
        
        if(!$service->checkAcl('view')) {
            throw new Keplin_ProhibitedException('Viewing Log: Access Prohibited.');
        }
        
        if(!$service->logExists()) {
            throw new Exception('Log doesn\'t exist.');
        }
        
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $service->display();
    }
    
    public function deleteLogAction()
    {
        $service = new Service_Log();
        
        if(!$service->checkAcl('delete'))
        {
            throw new Keplin_ProhibitedException('Delete Log: Access Prohibited.');
        }
        
        if(!$service->logExists())
        {
            throw new Exception('Log doesn\'t exist.');
        }
        
        if($this->_request->isPost())
        {
            $service->delete();   
        }
        
        $this->view->form = $service->getForm();
        $this->view->message = $service->getMessage();
    }
}