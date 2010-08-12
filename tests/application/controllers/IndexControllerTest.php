<?php
class IndexControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
        $this->dispatch('/');
        $this->assertController('index');
        $this->assertAction('index');
    }
    
    public function testContactAction()
    {        
        $this->dispatch('/contact');
        $this->assertController('index');
        $this->assertAction('contact');
        
        $this->request->setMethod('POST')
             ->setPost(array(
                'name' => 'Rob Test',
                'email' => 'rkeplin@gmail.com',
                'website' => 'http://www.robkeplin.com',
                'comment' => 'Unit test'
             ));
        $this->dispatch('/contact');
        $this->assertController('index');
        $this->assertAction('contact');
    }
    
    public function testPhotographyAction()
    {
        $this->dispatch('/index/photography');
        $this->assertController('index');
        $this->assertAction('photography');
    }
    
    public function testAboutAction()
    {
        $this->dispatch('/about');
        $this->assertController('index');
        $this->assertAction('about');
    }
}