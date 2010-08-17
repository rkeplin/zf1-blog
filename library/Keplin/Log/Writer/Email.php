<?php
class Keplin_Log_Writer_Email extends Zend_Log_Writer_Abstract
{
    static public function factory($config)
    {
        //Nothing to do 
    }
    
    protected function _write($event)
    {
        $mail = new Keplin_Mail_Error();
        $mail->send($event);
    }
}