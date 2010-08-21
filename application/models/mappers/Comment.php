<?php
class Model_Mapper_Comment 
    extends Keplin_Model_Mapper_Abstract
{
    public function save(Model_Comment $comment)
    {
        if($comment->id)
        {
            $where[] = 'id = ' . $comment->id;
            $this->_db->update('comments', $comment->toArray(), $where);
        }
        else
        {
            $this->_db->insert('comments', $comment->toArray());
            $comment->id = $this->_db->lastInsertId();
        }
        
        return $comment;
    }
    
    public function getComment($id)
    {
        $select = $this->_db->select()->from(array('c' => 'comments'))->where('id = ?', $id);
        $comment = $this->_db->fetchRow($select);
        
        return new Model_Comment($comment);
    }
    
    public function getPostComments($id)
    {
        $select = $this->_db->select()->from(array('c' => 'comments'))->where('post_id = ?', $id)->order('date_added ASC');
        $comment = $this->_db->fetchAll($select);
        
        return new Model_CommentCollection($comment);
    }
    
    public function delete($id)
    {
        $where[] = 'id = ' . $this->_db->quote($id);
        $this->_db->delete('comments', $where);
    }
    
    public function fetchPaged($page = 1, $per_page = 10)
    {
        $select = $this->_db->select()->from(array('c' => 'comments'))->order('date_added DESC');
        
        $adapter = new Keplin_Paginator_Adapter('Model_CommentCollection', $select);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($per_page);
        
        return $paginator;
    }
}