<?php
class Zend_View_Helper_Flickr extends Zend_View_Helper_Abstract
{
    public function flickr($num_photos)
    {
        $service = new Service_Flickr();
        $service->setPage(1);
        $service->setPerPage($num_photos);
        $photos = $service->fetchPhotosFromUsername('rkeplin');
        
        $string = '';
        
        foreach($photos as $photo)
        {
            $string .= '<a title="photography by rob" href="/photography">' . $photo->printImage('s') . '</a>' . "\r\n";
        }
        
        return $string;
    }
}