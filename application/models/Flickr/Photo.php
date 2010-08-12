<?php
class Model_Flickr_Photo extends Keplin_Model_Abstract
{
    public $id;
    public $owner;
    public $secret;
    public $server;
    public $farm;
    public $title;
    public $ispublic;
    public $isfriend;
    public $isfamily;
    
    private static $_valid_sizes = array('s', 't', 'm', '-', 'b', 'o');
    
    public function printImage($size = 's')
    {
        if(!in_array($size, self::$_valid_sizes))
            throw new Exception("Invalid Photo Size");
            
        return "<img alt=\"{$this->title}\" src=\"http://farm{$this->farm}.static.flickr.com/{$this->server}/{$this->id}_{$this->secret}_{$size}.jpg\" />";
    }
    
    public function printLink($image_string, $size = 'b')
    {
        if(!in_array($size, self::$_valid_sizes))
            throw new Exception("Invalid Photo Size");
            
        return "<a href=\"http://farm{$this->farm}.static.flickr.com/{$this->server}/{$this->id}_{$this->secret}_{$size}.jpg\">{$image_string}</a>";
    }
}