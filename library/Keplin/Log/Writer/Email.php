<?php
class Keplin_Log_Writer_Email extends Zend_Log_Writer_Abstract
{
    static public function factory($config)
    {
        return new self();
    }
    
    protected function _write($event)
    {
        $mail = new Keplin_Mail_Error();
        $mail->send($event);
    }
}