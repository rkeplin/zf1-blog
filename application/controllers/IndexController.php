<?php
class IndexController extends Zend_Controller_Action
{
    public function aboutAction(){}
        
    public function indexAction()
    {
        $service = new Service_Post();
        $post = $service->getLatest();
        
        $this->view->post = $post;
    }
    
    public function photographyAction()
    {
        $service = new Service_Flickr();
        $service->setPage($this->_request->getParam('page'));
        
        $photos = $service->fetchPhotosFromUsername('rkeplin');
        
        $this->view->photos = $photos;
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
}