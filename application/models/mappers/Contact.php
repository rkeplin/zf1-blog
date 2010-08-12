<?php
class Model_Mapper_Contact
{
    public function send(Model_Contact $contact)
    {
        $mailer = new Keplin_Mail_Contact();
        $mailer->send($contact);
    }
}