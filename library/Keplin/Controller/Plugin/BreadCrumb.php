<?php
class Keplin_Controller_Plugin_BreadCrumb extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if(APPLICATION_ENV != 'testing')
        {
            $view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('view');
            $container = new Zend_Navigation(Keplin_Pages::getPages($request));
            $view->navigation($container);   
        }
    }
}