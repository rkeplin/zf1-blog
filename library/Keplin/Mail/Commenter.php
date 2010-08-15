<?php
class Keplin_Mail_Commenter 
    extends Keplin_Mail
        implements SplObserver, Keplin_Mail_CommentInterface
{
    public function update(SplSubject $subject)
    {
        $comment = $subject->getComment();
        
        if($comment->parent_id)
        {
            $mapper = new Model_Mapper_Comment();
            $parent_comment = $mapper->getComment($comment->parent_id);
            $this->send($parent_comment, $subject->getPost());
        }
    }
    
    public function send(Model_Comment $comment, Model_Post $post)
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
        $this->_send($mail);
    }
}