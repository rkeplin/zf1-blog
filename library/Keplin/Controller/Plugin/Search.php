<?php
class Keplin_Controller_Plugin_Search extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if($request->getControllerName() == 'blog' && $request->getActionName() == 'search-handler')
        {
            $url = '/blog/search/';
            
            if($year = $request->getParam('year'))
            {
                $url .= 'year/' . $year . '/';
            }
            
            if($category = $request->getParam('category'))
            {
                $url .= 'category/' . $category . '/';
            }
            
            if($query = $request->getParam('query'))
            {
                $url .= 'query/' . $query . '/';
            }
            
            $this->_response->setRedirect($url);
        }
    }
}