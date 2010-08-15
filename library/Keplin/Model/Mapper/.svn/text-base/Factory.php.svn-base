<?php
abstract class Keplin_Model_Mapper_Factory 
{
    public static function create($class_name, $enable_caching = false) 
    {
        switch($class_name)
        {
            case 'User':
                return new Model_Mapper_User();
                break;
                
            case 'Comment':
                
                if($enable_caching)
                {
                    return new Model_Mapper_Cache_Comment();
                }
                
                return new Model_Mapper_Comment();
                
                break;
            case 'Category':
                
                if($enable_caching)
                {
                    return new Model_Mapper_Cache_Category();
                }
                
                return new Model_Mapper_Category();
                
                break;
            case 'Post':
                if($enable_caching) 
                {
                    return new Model_Mapper_Cache_Post();    
                }
                
                return new Model_Mapper_Post();
                
                break;
            default:
                throw new Exception('Class name not found.');
                break;
        }
    }
}