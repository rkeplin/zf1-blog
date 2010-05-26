<?php
class Model_PostCollection extends Keplin_Model_Collection_Abstract
{
    public function __construct($results)
    {
        parent::__construct('Model_Post', $results);
    }
}