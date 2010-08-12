<?php
class Model_Mapper_User 
    extends Keplin_Model_Mapper_Abstract
{
    private $_user;
    
    public function setUser(Model_User $user)
    {
        $this->_user = $user;
    }
    
    public function save(Model_User $user)
    {
        if($user->id)
        {
            $where[] = 'id = ' . $user->id;
            $this->_db->update('users', $user->toArray(), $where);
        }
        else
        {
            $this->_db->insert('users', $user->toArray());
            $user->id = $this->_db->lastInsertId();
        }
        
        return $user;
    }
    
    public function login(Model_User $user)
    {
        $select = $this->_db->select()->from(array('u' => 'users'))
                            ->where('email = ?', $user->email)
                            ->where('password = ?', $user->password);
        
        $data = (array)$this->_db->fetchRow($select);
        $user->setOptions($data);
        
        return $user;
    }
    
    public function getUser($id)
    {
        $select = $this->_db->select()->from(array('u' => 'users'))->where('id = ?', $id);
        $user = $this->_db->fetchRow($select);
        
        return new Model_User($user);
    }
    
    public function getUserByEmail($email)
    {
        $select = $this->_db->select()->from(array('u' => 'users'))->where('email = ?', $email);
        $data = $this->_db->fetchRow($select);
        
        $user = new Model_User($data);
        
        return $user;
    }
    
    public function getPagedUsers($page = 1)
    {
        $select = $this->_db->select()->from(array('u' => 'users'), array('id', 'name', 'email'));
        
        $adapter = new Keplin_Paginator_Adapter('Model_UserCollection', $select);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        
        return $paginator;
    }
}