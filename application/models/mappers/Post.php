<?php
class Model_Mapper_Post 
    extends Keplin_Model_Mapper_Abstract
{
    public $is_published;
    
    public function __construct()
    {
        parent::__construct();
        $this->is_published = 1;
    }
    
    public function save(Model_Post $post)
    {
        if($post->id)
        {
            $where[] = 'id = ' . $post->id;
            $this->_db->update('posts', $post->toArray(), $where);
        }
        else
        {
            $this->_db->insert('posts', $post->toArray());
        }
    }
    
    public function getRssFeed()
    {
        $select = $this->_db->select()->from(array('p' => 'posts'), array('title', 'content', 'date_added', 'date_modified'))
                                      ->join(array('c' => 'categories'), 'c.id = p.category_id', array('category' => 'name'))
                                      ->where('p.is_published = 1')
                                      ->order('date_modified DESC')
                                      ->limit(10);
        $data = $this->_db->fetchAll($select);
        
        return new Model_PostCollection($data);
    }
    
    protected function _filter($select)
    {
        if($this->is_published)
        {
            $select->where('p.is_published = ?', $this->is_published);
        }
        
        return $select;
    }
    
    public function query($data, $page = 1)
    {
        $select = $this->_db->select()->from(array('p' => 'posts'), array('id', 'title', 'content', 'date_added', 'date_modified'))
                                      ->join(array('c' => 'categories'), 'c.id = p.category_id', array('category' => 'name'));
        $select = $this->_filter($select);
        
        if(isset($data['query']) && $data['query'])
        {
            $select->where('c.name LIKE "%'. addslashes($data['query']) .'%" OR p.title LIKE "%'. addslashes($data['query']) .'%" OR p.content LIKE "%'. addslashes($data['query']) .'%"');
        }
                                      
        if(isset($data['category']) && $data['category'])
        {
            $select->where('c.name = ?', $data['category']);
        }
        
        if(isset($data['year']) && $data['year'])
        {
            $select->where('YEAR(p.date_added) = ?', $data['year']);
        }
        
        $adapter = new Keplin_Paginator_Adapter('Model_PostCollection', $select);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(5);
         
        return $paginator;
    }
    
    public function getFromTitle($title)
    {
        $select = $this->_db->select()->from(array('p' => 'posts'))
                                      ->joinLeft(array('u' => 'users'), 'u.id = p.user_id', array('user_id' => 'id', 'user_name' => 'name', 'email'))
                                      ->joinLeft(array('c' => 'categories'), 'c.id = p.category_id', array('category_id' => 'id', 'category_name' => 'name'))
                                      ->where('p.title = ?', $title);
        $select = $this->_filter($select);
        
        $data = $this->_db->fetchRow($select);
        
        $post = new Model_Post($data);
        
        $post->category = new Model_Category();
        $post->category->id = $data['category_id'];
        $post->category->name = $data['category_name'];
        
        $post->user = new Model_User();
        $post->user->id = $data['user_id'];
        $post->user->name = $data['user_name'];
 
        $mapper_comments = new Model_Mapper_Comment();
        $comments = $mapper_comments->getPostComments($post->id);
        $post->comments = $comments;
        
        return $post;
    }
    
    public function fetchLatest()
    {
        $select = $this->_db->select()->from(array('p' => 'posts'))
                                      ->joinLeft(array('u' => 'users'), 'u.id = p.user_id', array('user_id' => 'id', 'user_name' => 'name', 'email'))
                                      ->joinLeft(array('c' => 'categories'), 'c.id = p.category_id', array('category_id' => 'id', 'category_name' => 'name'))
                                      ->order('p.date_added DESC')
                                      ->limit(1);
        $select = $this->_filter($select);
        $data = $this->_db->fetchRow($select);
        
        $post = new Model_Post($data);
        
        $post->category = new Model_Category();
        $post->category->id = $data['category_id'];
        $post->category->name = $data['category_name'];
        
        $post->user = new Model_User();
        $post->user->id = $data['user_id'];
        $post->user->name = $data['user_name'];
        
        return $post;
    }
    
    public function getPost($id, $is_published = 1)
    {
        $select = $this->_db->select()->from(array('p' => 'posts'))
                                      ->joinLeft(array('u' => 'users'), 'u.id = p.user_id', array('user_id' => 'id', 'user_name' => 'name', 'email'))
                                      ->joinLeft(array('c' => 'categories'), 'c.id = p.category_id', array('category_id' => 'id', 'category_name' => 'name'))
                                      ->where('p.id = ?', $id);
        $select = $this->_filter($select);
        $data = $this->_db->fetchRow($select);
        
        $post = new Model_Post($data);
        
        $post->category = new Model_Category();
        $post->category->id = $data['category_id'];
        $post->category->name = $data['category_name'];
        
        $post->user = new Model_User();
        $post->user->id = $data['user_id'];
        $post->user->name = $data['user_name'];
        
        $mapper_comments = new Model_Mapper_Comment();
        $comments = $mapper_comments->getPostComments($post->id);
        $post->comments = $comments;
        
        return $post;
    }
    
    public function fetchValidYears()
    {
        $select = $this->_db->select()->from(array('p' => 'posts'), array('min_year' => 'MIN(YEAR(date_added))', 'max_year' => 'MAX(YEAR(date_added))'));
        $select = $this->_filter($select);
                            
        $data = $this->_db->fetchRow($select);
        
        return $data;
    }
    
    public function getRecentPosts($limit)
    {
        $select = $this->_db->select()->from(array('p' => 'posts'), array('id', 'title', 'date_added'))
                                      ->join(array('c' => 'categories'), 'c.id = p.category_id', array('category' => 'name'))
                                      ->order('p.date_added DESC')
                                      ->limit($limit);
        $select = $this->_filter($select);
                                      
        $data = $this->_db->fetchAll($select);
        
        return new Model_PostCollection($data);
    }
    
    public function delete(Model_Post $post)
    {
        $where[] = 'id = ' . $this->_db->quote($post->id);
        $this->_db->delete('posts', $where);
    }
    
    public function getFromCategory($category, $page = 1)
    {
        $select = $this->_db->select()->from(array('p' => 'posts'), array('id', 'title', 'date_added', 'date_modified'))
                                      ->join(array('c' => 'categories'), 'c.id = p.category_id')
                                      ->where('c.name = ?', $category);
        $select = $this->_filter($select);
        
        $adapter = new Keplin_Paginator_Adapter('Model_PostCollection', $select);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        
        return $paginator;
    }
    
    public function getFromArchive($year, $page = 1)
    {
        $select = $this->_db->select()->from(array('p' => 'posts'), array('id', 'title', 'date_added', 'date_modified'))
                                      ->join(array('c' => 'categories'), 'c.id = p.category_id', array('category' => 'name'))
                                      ->where('YEAR(p.date_added) = ?', $year);
        $select = $this->_filter($select);
        
        $adapter = new Keplin_Paginator_Adapter('Model_PostCollection', $select);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        
        return $paginator;
    }
    
    
    public function getPagedTitles($page = 1)
    {
        $select = $this->_db->select()->from(array('p' => 'posts'), array('id', 'title', 'date_added', 'date_modified', 'is_published'))
                                      ->join(array('c' => 'categories'), 'c.id = p.category_id', array('category' => 'name'))
                                      ->order('p.date_added DESC');
        $select = $this->_filter($select);
        
        $adapter = new Keplin_Paginator_Adapter('Model_PostCollection', $select);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        
        return $paginator;
    }
}