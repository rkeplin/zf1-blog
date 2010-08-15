<?php
class AdminControllerTest extends ControllerTestCase
{
    public function testLogout()
    {
        $this->_login();
        $this->dispatch('/admin/logout/');
    }
    
    public function testIndex()
    {
        $this->dispatch('/admin/index/');
        $this->assertController('error');
        $this->assertAction('error');
        
        $this->_login();
        $this->dispatch('/admin/index/');
        $this->assertController('admin');
        $this->assertAction('index');
        $this->_logout();
    }
    
    public function testLogin()
    {
        $this->dispatch('/admin/login/');
        $this->assertController('admin');
        $this->assertAction('login');
        
        $this->_login();
        $this->_logout();
    }
    
    public function testCreatePost()
    {
        $this->dispatch('/admin/create-post/');
        $this->assertController('error');
        $this->assertAction('error');
        
        $this->_login();
        $this->dispatch('/admin/create-post/');
        $this->assertController('admin');
        $this->assertAction('create-post');
        
        $this->request->setMethod('POST')
             ->setPost(array(
                'title' => 'Test!!!!!!!!' . time(),
                'content' => 'The test content.',
                'category_id' => '5',
                'new_category' => '',
                'is_published' => 1
             ));
        $this->dispatch('/admin/create-post/');
        //echo $this->getResponse()->getBody(false);
        $this->assertController('admin');
        $this->assertAction('create-post');
        
        $mapper = new Model_Mapper_Post();
        $post = $mapper->fetchLatest();
        $mapper->delete($post);
        
        $this->_logout();
    }
    
    public function testEditPost()
    {
        $this->dispatch('/admin/edit-post/id/97');
        $this->assertController('error');
        $this->assertAction('error');
        
        $this->_login();
        $this->dispatch('/admin/edit-post/');
        $this->assertController('admin');
        $this->assertAction('edit-post');
        
        $this->request->setMethod('POST')
             ->setPost(array(
                'title' => 'Edit 123' . time(),
                'content' => 'The test content that was edited.',
                'category_id' => '5',
                'new_category' => '',
                'is_published' => 1
             ));
        $this->dispatch('/admin/edit-post/id/97');
        $this->assertController('admin');
        $this->assertAction('edit-post');
        
        $this->_logout();
        
    }
    
    protected function _login()
    {
        //Bad Login
        $this->request->setMethod('POST')
             ->setPost(array(
                'email' => 'test@test.com',
                'password' => 'asdf'
             ));
        $this->dispatch('/admin/login/');
        $this->assertAction('login');
        
        //Good Login
        $this->request->setMethod('POST')
             ->setPost(array(
                'email' => 'test@test.com',
                'password' => 'test'
             ));
        $this->dispatch('/admin/login/');
        
        $this->assertRedirectTo('/admin');
    }
    
    protected function _logout()
    {
        $this->dispatch('/admin/logout/');
        $this->assertController('admin');
        $this->assertAction('logout');
    }
}