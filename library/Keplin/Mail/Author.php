<?php
class Keplin_Mail_Author 
    extends Keplin_Mail
        implements SplObserver, Keplin_Mail_CommentInterface
{
    public function update(SplSubject $subject)
    {
        $this->send($subject->getComment(), $subject->getPost());
    }
    
    public function send(Model_Comment $comment, Model_Post $post)
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
        $this->_send($mail);
    }
}