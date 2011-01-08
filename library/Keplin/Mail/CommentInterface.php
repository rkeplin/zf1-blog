<?php
interface Keplin_Mail_CommentInterface 
{
    public function send(Blog\Entity\Comment $comment, Blog\Entity\Post $post);
}