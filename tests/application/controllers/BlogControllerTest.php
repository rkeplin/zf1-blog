<?php
class BlogControllerTest extends ControllerTestCase
{
    public function testCategoriesAction()
    {
        $this->dispatch('/blog/categories/');
        $this->assertController('blog');
        $this->assertAction('categories');
    }
    
    public function testCategoryAction()
    {
        $this->dispatch('/blog/category/Java');
        $this->assertController('blog');
        $this->assertAction('category');
    }
    
    public function testRssAction()
    {
        $this->dispatch('/blog/rss/');
        $this->assertController('blog');
        $this->assertAction('rss');
    }
    
    public function testArchivesAction()
    {
        $this->dispatch('/blog/archives/');
        $this->assertController('blog');
        $this->assertAction('archives');
    }

    public function testArchiveAction()
    {
        $this->dispatch('/blog/archive/2010');
        $this->assertController('blog');
        $this->assertAction('archive');
    }
    
    public function testSearchAction()
    {
        $this->dispatch('/blog/search/query/test/');
        $this->assertController('blog');
        $this->assertAction('search');
    }
    
    public function testViewAction()
    {
        $this->dispatch('/blog/view/Java/Beginning+Classes+in+Java/');
        $this->assertController('blog');
        $this->assertAction('view');
        
        $this->request->setMethod('POST')
             ->setPost(array(
                'parent_id' => 0,
                'name' => 'Rob Test',
                'email' => 'rkeplin@gmail.com',
                'website' => 'http://www.robkeplin.com',
                'comment' => 'Unit test'
             ));
        $this->dispatch('/blog/view/Java/Beginning+Classes+in+Java/');
        $this->assertController('blog');
        $this->assertAction('view');
    }

}