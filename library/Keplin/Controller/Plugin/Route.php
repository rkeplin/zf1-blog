<?php
class Keplin_Controller_Plugin_Route extends Zend_Controller_Plugin_Abstract
{
    public function routeStartup(Zend_Controller_Request_Abstract $request)
	{
		$contact_route = new Zend_Controller_Router_Route_Static(
			"contact",
			array(
				"controller" => "index",
				"action" => "contact"
			)
		);
        
        $about_route = new Zend_Controller_Router_Route_Static(
			"about",
			array(
				"controller" => "index",
				"action" => "about"
			)
		);
        
        $photo_route = new Zend_Controller_Router_Route(
			"photography/:page",
			array(
				"controller" => "index",
				"action" => "photography",
                "page" => 1
			),
            array(
                'page' => '\d+'
            )
		);
        
        $archive_route = new Zend_Controller_Router_Route(
            'blog/archive/:year',
            array(
                'year' => 2010,
                'controller' => 'blog',
                'action'     => 'archive'
            ),
            array(
                'year' => '\d+'
            )
        );
        
        $category_route = new Zend_Controller_Router_Route(
            'blog/category/:category',
            array(
                'category' => 'Nothing',
                'controller' => 'blog',
                'action'     => 'category'
            )
        );
        
        $blog_route = new Zend_Controller_Router_Route(
            'blog/view/:category/:title',
            array(
                'category' => 'Nothing',
                'title' => 'Nothing',
                'controller' => 'blog',
                'action'     => 'view'
            )
        );
        
		
        $fc = Zend_Controller_Front::getInstance();
		$router = $fc->getRouter();
		$router->addRoute("contact_route", $contact_route);
        $router->addRoute("about_route", $about_route);
        $router->addRoute("photography_route", $photo_route);
        $router->addRoute("archive_route", $archive_route);
        $router->addRoute("category_route", $category_route);
        $router->addRoute("blog_route", $blog_route);
        
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        #Zend_Debug::dump($request->getParams());
        #exit;
    }
}