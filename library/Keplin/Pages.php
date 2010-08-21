<?php
class Keplin_Pages
{
    public static function getPages(Zend_Controller_Request_Abstract $request)
    {
        return array(
            array(
                'label' => 'Home',
                'module' => 'default',
                'controller' => 'index',
                'action' => 'index',
                'route' => 'default',
                'pages' => 
                array(
                    array(
                        'label' => 'Archives',
                        'module' => 'default',
                        'controller' => 'blog',
                        'action' => 'archives',
                        'route' => 'default',
                        'pages' =>
                        array(
                            array(
                                'label' => $request->getParam('year'),
                                'module' => 'default',
                                'route' => 'archive_route',
                                'controller' => 'blog',
                                'action' => 'archive',
                            )
                        )
                    ),
                    array(
                        'label' => 'Photography',
                        'module' => 'default',
                        'controller' => 'index',
                        'action' => 'photography',
                    ),
                    array(
                        'label' => 'Search',
                        'module' => 'default',
                        'controller' => 'blog',
                        'action' => 'search',
                    ),
                    array(
                        'label' => 'About',
                        'module' => 'default',
                        'controller' => 'index',
                        'action' => 'about',
                        'route' => 'about_route'
                    ),
                    array(
                        'label' => 'Contact',
                        'module' => 'default',
                        'controller' => 'index',
                        'action' => 'contact',
                    ),
                    array(
                        'label' => 'Categories',
                        'module' => 'default',
                        'controller' => 'blog',
                        'action' => 'categories',
                        'route' => 'default',
                        'pages' =>
                        array(
                            array(
                                'label' => $request->getParam('category'),
                                'module' => 'default',
                                'controller' => 'blog',
                                'action' => 'category',
                                'params' => array('category' => $request->getParam('category')),
                                'route' => 'category_route',
                                'pages' =>
                                array(
                                    array(
                                        'label' => $request->getParam('title'),
                                        'module' => 'default',
                                        'controller' => 'blog',
                                        'action' => 'view'
                                    )
                                )
                            )
                        )
                    ),
                    array(
                        'label' => 'Login',
                        'module' => 'default',
                        'controller' => 'admin',
                        'action' => 'login',
                    ),
                    array(
                        'label' => 'Admin Panel',
                        'module' => 'default',
                        'controller' => 'admin',
                        'action' => 'index',
                        'pages' =>
                        array(
                            array(
                                'label' => 'Create Post',
                                'module' => 'default',
                                'controller' => 'admin',
                                'action' => 'create-post',
                            ),
                            array(
                                'label' => 'Edit Post',
                                'module' => 'default',
                                'controller' => 'admin',
                                'action' => 'edit-post',
                            ),
                            array(
                                'label' => 'Delete Log',
                                'module' => 'default',
                                'controller' => 'admin',
                                'action' => 'delete-log',
                            ),
                            array(
                                'label' => 'Comments',
                                'module' => 'default',
                                'controller' => 'admin',
                                'action' => 'comments',
                            )
                        )
                    )
                )
            )
        );
    }
}