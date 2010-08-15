<?php
class Keplin_Mail_Contact extends Keplin_Mail
{
    public function send(Model_Contact $contact)
    {
        $mail = new Zend_Mail();
        $mail->setSubject('From robkeplin.com');
        $mail->setBodyHtml(nl2br($contact->comment) . '<br><br>' . $contact->name . '<br>' . $contact->website);
        $mail->setFrom($contact->email, $contact->name);
        $mail->addTo('rkeplin@gmail.com');
        $this->_send($mail);
    }
}