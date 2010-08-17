<?php
class Keplin_Mail_Error 
    extends Keplin_Mail
{
    public function send($event)
    {
        $mail = new Zend_Mail();
        $mail->setSubject("{$event['priorityName']}: robkeplin.com");
        
        $message = "<b>IP: </b>{$_SERVER['REMOTE_ADDR']} <br>
                    <b>Message:</b> {$event['message']} <br>";
        
        $mail->setBodyHtml($message);
        $mail->setFrom('rkeplin@gmail.com', 'Rob Keplin');
        $mail->addTo('rkeplin@gmail.com');
        $this->_send($mail);
    }
}