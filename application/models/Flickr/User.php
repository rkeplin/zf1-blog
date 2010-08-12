<?php
class Model_Flickr_User extends Keplin_Model_Abstract
{
    public $id;
    public $nsid;
    public $username;
    
    public function setUsername($value)
    {
        if(is_array($value))
        {
            if(isset($value['_content']))
            {
                $this->username = $value['_content'];
            }
        }
    }
}