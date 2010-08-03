<?php
interface Model_Mapper_CommentInterface
{
    public function save(Model_Comment $comment);
    public function getComment($id);
    public function getPostComments($id);
    public function getPagedComments($page);
}