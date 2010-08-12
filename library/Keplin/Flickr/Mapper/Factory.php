<?php
abstract class Keplin_Flickr_Mapper_Factory 
{
    public static function create($name, $enable_caching = false)
    {
        switch($name)
        {
            case 'User':
                if($enable_caching) 
                {
                    return new Model_Mapper_Cache_Flickr_User();    
                }
                
                return new Model_Mapper_Flickr_User();
                
                break;
            case 'Photo':
                if($enable_caching) 
                {
                    return new Model_Mapper_Cache_Flickr_Photo();        
                }
                
                return new Model_Mapper_Flickr_Photo();
                
                break;
            default:
                throw new Exception('Flickr_Mapper supplied is not valid.');
                break;
        }
    }    
}