<?php
class Model_Flickr_PhotoCollection extends Keplin_Model_Collection_Abstract
{
    public function __construct($results)
    {
        parent::__construct('Model_Flickr_Photo', $results);
    }
}