<?php
class Model_Mapper_Flickr_Photo extends Keplin_Flickr_Mapper_Abstract
{
    public function fetchPaged(Model_Flickr_User $user, $page = 1, $per_page = 25, $sort = 'date-taken-desc')
    {
        $this->_removeAllOptions();
        $this->_setOption('method', 'flickr.people.getPublicPhotos');
        $this->_setOption('user_id', $user->id);
        $this->_setOption('page', $page);
          
        if(isset($per_page))
            $this->_setOption('per_page', $per_page);
        
        if(isset($sort))
            $this->_setOption('sort', $sort);
        
        $results = unserialize(file_get_contents($this->_buildUrl()));
        
        $collection = new Model_Flickr_PhotoCollection($results['photos']['photo']);
        
        $adapter = new Keplin_Flickr_Adapter($collection, $results['photos']['total']);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($per_page);
         
        return $paginator;
    }
}