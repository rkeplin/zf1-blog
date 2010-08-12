<?php
class Model_Mapper_Flickr_User extends Keplin_Flickr_Mapper_Abstract
{
    public function fetchOne($username)
    {
        $this->_removeAllOptions();
        $this->_setOption('method', 'flickr.people.findByUsername');
        $this->_setOption('username', $username);

        $results = unserialize(file_get_contents($this->_buildUrl()));
        $entity = new Model_Flickr_User($results['user']);
        
        return $entity;
    }
}