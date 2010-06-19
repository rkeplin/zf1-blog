<?php
class AdminController extends Zend_Controller_Action
{
    public function indexAction(){}
    
    public function loginAction()
    {
        $service = new Service_User();
        
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
        
        if($this->_request->isPost())
        {
            $service->create($this->_request->getParams());
        }
        
        $this->view->message = $service->getMessage();
        $this->view->form = $service->getForm();
    }
    
    public function viewPostsAction()
    {
       $mapper_post = new Model_Mapper_Post();
       $mapper_post->is_published = 0;
       $posts = $mapper_post->getPagedTitles($this->_request->getParam('page'));
       
       $this->view->posts = $posts;
    }
    
    public function editPostAction()
    {
        $service = new Service_Post();
        $form = $service->getForm($this->_request->getParam('id'));
        
        if($this->_request->isPost())
        {
            $service->update($this->_request->getParams());
        }
        
        $this->view->message = $service->getMessage();
        $this->view->form = $form;
    }
}