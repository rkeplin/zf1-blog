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
        
        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $this->_options);
        Zend_Mail::setDefaultTransport($transport);
    }
    
    public function sendContact(Model_Contact $contact)
    {
        $mail = new Zend_Mail();
        $mail->setSubject('From robkeplin.com');
        $mail->setBodyHtml(nl2br($contact->comment) . '<br><br>' . $contact->name . '<br>' . $contact->website);
        $mail->setFrom($contact->email, $contact->name);
        $mail->addTo('rkeplin@gmail.com');
        $mail->send();
    }
    
    public function sendRobComment(Model_Comment $comment, Model_Post $post)
    {
        $mail = new Zend_Mail();
        $mail->setSubject('Comment from robkeplin.com');
        
        $message = 'Rob,
            <br><br>
            Someone has responed to your post on www.robkeplin.com! 
            You can view it <a href="http://www.robkeplin.com/blog/view/'. urlencode($post->category->name) .'/'. urlencode($post->title) .'/">here</a>.<br><br>
            Thanks, <br />Rob<br /><a href="http://www.robkeplin.com">www.robkeplin.com</a>';
        
        $mail->setBodyHtml($message);
        $mail->setFrom('rkeplin@gmail.com', 'Rob Keplin');
        $mail->addTo('rkeplin@gmail.com');
        $mail->send();
    }
    
    public function sendCommentResponse(Model_Comment $comment, Model_Post $post)
    {
        $mail = new Zend_Mail();
        $mail->setSubject('Response from robkeplin.com');
        
        $message = $comment->name . ',
            <br><br>
            Someone has responed to your comment on www.robkeplin.com! 
            You can view it <a href="http://www.robkeplin.com/blog/view/'. urlencode($post->category->name) .'/'. urlencode($post->title) .'/">here</a>.<br><br>
            Thanks, <br />Rob<br /><a href="http://www.robkeplin.com">www.robkeplin.com</a>';
        
        $mail->setBodyHtml($message);
        $mail->setFrom('rkeplin@gmail.com', 'Rob Keplin');
        $mail->addTo($comment->email);
        $mail->addBcc('rkeplin@gmail.com');
        $mail->send();
    }
    
    public static function setOptions(array $options)
    {
        if(null === self::$_defaultOptions)
        {
            self::$_defaultOptions = $options;
        }
    }
}