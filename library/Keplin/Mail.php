<?php
class Keplin_Mail
{
    protected static $_defaultOptions;
    protected $_options;
    
    public function __construct(array $options = null)
    {
        if(null === $options)
        {
            $this->_options = self::$_defaultOptions;
        }
        else
        {
            $this->_options = $options;
        }
        
        if(null === $this->_options)
        {
            throw new Exception('No default options were set for Keplin_Mail');
        }
        
        if(APPLICATION_ENV != 'production')
        {
            $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $this->_options);
            Zend_Mail::setDefaultTransport($transport);
        }
    }
    
    protected function _send(Zend_Mail $mail)
    {
        if(APPLICATION_ENV != 'testing')
        {
            $mail->send();
        }
    }
    
    public static function setOptions(array $options)
    {
        if(null === self::$_defaultOptions)
        {
            self::$_defaultOptions = $options;
        }
    }
}