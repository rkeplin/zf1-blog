<?php
class Model_CommentCollection extends Keplin_Model_Collection_Abstract
{
    public function __construct($results)
    {
        parent::__construct('Model_Comment', $results);
    }
}