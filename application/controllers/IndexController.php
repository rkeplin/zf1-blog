<?php
class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $mapper_post = new Model_Mapper_Cache_Post();
        $post = $mapper_post->fetchLatest();
        
        $this->view->post = $post;
    }
    
    public function contactAction()
    {
        $service = new Service_Contact();
        
        if($data = $this->_request->getPost())
        {
            $service->send($data);
        }
        
        $this->view->message= $service->getMessage();
        $this->view->form = $service->getForm();
    }
    
    public function aboutAction(){}
}