<?php
class Model_QuoteCollection extends Keplin_Model_Collection_Abstract
{
    public function __construct($results)
    {
        parent::__construct('Model_Quote', $results);
    }
}