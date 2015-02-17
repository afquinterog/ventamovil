<?php 

require 'Zebra_Image.php';
 
class Image{

	/**
	* 
	*/
	function resize($img, $dest, $width, $height=0 ){
	
		
		$image = new Zebra_Image();
		$image->source_path = $img;
		
		//Obtiene extension
		//$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
		
		// indicate a target image
		$image->target_path = $dest;
		
		$image->preserve_aspect_ratio = true;
		$image->enlarge_smaller_images = true;

		// resize
		// and if there is an error, show the error message
		if ($image->resize($width, $height, ZEBRA_IMAGE_CROP_CENTER, -1)) {
			return true;
		}
		else{
			return false;
		}
		//if (!$image->resize(175, 46, ZEBRA_IMAGE_CROP_CENTER, -1)) show_error($image->error, $image->source_path, $image->target_path);
		
		
	}
	
}

/*
$image = new Zebra_Image();
		$image->source_path = 'images/fondo2.jpg';
		//Obtiene extension
		$ext = substr($image->source_path, strrpos($image->source_path, '.') + 1);
		// indicate a target image
		$image->target_path = 'images/logo3.' . $ext;
		
		$image->preserve_aspect_ratio = true;
		$image->enlarge_smaller_images = true;

		// resize
		// and if there is an error, show the error message
		if (!$image->resize(175, 0, ZEBRA_IMAGE_BOXED, -1)) show_error($image->error, $image->source_path, $image->target_path);
*/





