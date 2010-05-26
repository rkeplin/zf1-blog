<?php

if(isset($_GET['url']))
{
	$default_size = 50;
	
	$width = (isset($_GET['width'])) ? $_GET['width'] : $default_size;
	$height =  (isset($_GET['height'])) ? $_GET['height'] : $default_size;
	
	require_once('lib/Image.php');
	
	$image = new Image();
	$image->getImage($_GET['url']);
	$image->resizeImage($width, $height);
	$image->displayImage();
}

?>