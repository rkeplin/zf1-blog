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
                    return new Keplin_Flickr_Mapper_Cache_User();
                }
                
                return new Keplin_Flickr_Mapper_User();
                
                break;
            case 'Photo':
                if($enable_caching) 
                {
                    return new Keplin_Flickr_Mapper_Cache_Photo();
                }
                
                return new Keplin_Flickr_Mapper_Photo();
                
                break;
            default:
                throw new Exception('Flickr_Mapper supplied is not valid.');
                break;
        }
    }    
}