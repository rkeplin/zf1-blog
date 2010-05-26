<?php
class Model_UserCollection extends Keplin_Model_Collection_Abstract
{
    public function __construct($results)
    {
        parent::__construct('Model_User', $results);
    }
}