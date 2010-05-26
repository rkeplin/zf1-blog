<?php
class Model_CategoryCollection extends Keplin_Model_Collection_Abstract
{
    public function __construct($results)
    {
        parent::__construct('Model_Category', $results);
    }
}