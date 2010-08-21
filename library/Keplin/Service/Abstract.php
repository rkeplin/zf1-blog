<?php
abstract class Keplin_Service_Abstract
{
    protected $_enable_caching;
    private $_msg = null;
    
    protected $_messageTemplate = array(
        'invalid_pass' => 'The credentials entered were incorrect.',
        'comment' => 'Successfully added comment!',
        'form_errors' => 'Please fix the errors below, detailed on the comment form.',
        'post_create' => 'Successfully created post!',
        'post_update' => 'Successfully updated post!',
        'contact' => 'Successfully sent message to Rob!',
        'delete-log' => 'Successfully deleted log.'
    );
    
    protected function _message($key)
    {
        if(!key_exists($key, $this->_messageTemplate))
        {
            throw new Exception('Message template key does not exist');
        }
        
        $this->_msg = $this->_messageTemplate[$key];
    }
    
    public function getMessage()
    {
        return $this->_msg;
    }
    
    public function enableCache()
    {
        $this->_enable_caching = true;
    }
    
    public function disableCache()
    {
        $this->_enable_caching = false;
    }
}