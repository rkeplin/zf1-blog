<?php
class Model_Mapper_Category 
    extends Keplin_Model_Mapper_Abstract
{
    public function save(Model_Category $category)
    {
        if($category->id)
        {
            $where[] = 'id = ' . $category->id;
            $this->_db->update('categories', $category->toArray(), $where);
        }
        else
        {
            $this->_db->insert('categories', $category->toArray());
            $category->id = $this->_db->lastInsertId();
        }
        
        return $category;
    }
    
    public function getCategory($id)
    {
        $select = $this->_db->select()->from(array('c' => 'categories'))->where('id = ?', $id);
        $category = $this->_db->fetchRow($select);
        
        return new Model_Category($category);
    }
    
    public function fetchAll($is_published = 1)
    {
        $select = $this->_db->select()->from(array('c' => 'categories'))
                            ->joinLeft(array('p' => 'posts'), 'p.category_id = c.id', array('num_posts' => 'COUNT(p.id)'))
                            ->group('c.name')
                            ->order('c.name');
        if($is_published)
        {
            $select->where('p.is_published = ?', $is_published);
        }
                            
        $categories = $this->_db->fetchAll($select);
        
        return new Model_CategoryCollection($categories);
    }
}