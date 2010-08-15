<?php
interface Keplin_Mail_CommentInterface 
{
    public function send(Model_Comment $comment, Model_Post $post);    
}