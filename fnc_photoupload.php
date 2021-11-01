<?php

	function save_image($image, $file_type, $target){
        $notice = null;
        
        if($file_type == "jpg"){
            if(imagejpeg($image, $target, 90)){
                $notice = "Foto salvestamine õnnestus!";
            } else {
                $notice = "Foto salvestamine ei õnnestunud!";
            }
        }
        
        if($file_type == "png"){
            if(imagepng($image, $target, 6)){
                $notice = "Foto salvestamine õnnestus!";
            } else {
                $notice = "Foto salvestamine ei õnnestunud!";
            }
        }
        
        if($file_type == "gif"){
            if(imagegif($image, $target)){
                $notice = "Foto salvestamine õnnestus!";
            } else {
                $notice = "Foto salvestamine ei õnnestunud!";
            }
        }
        
        return $notice;
    }
	
	function change_image_size($my_temp_image, $image_width, $image_height, $photo_width_limit, $photo_height_limit){
		if($image_width > $photo_width_limit or $image_height > $photo_height_limit){
			
		}
		
		if($image_width / $photo_width_limit > $image_height / $photo_height_limit) {
				$image_size_ratio = $image_width / $photo_width_limit;
			} else {
				$image_size_ratio = $image_height / $photo_height_limit;
			}
			$image_new_width = round($image_width / $image_size_ratio);
			$image_new_height = round($image_height / $image_size_ratio);
			//loome uue, väiksema pildiobjekti
			$my_new_temp_image = imagecreatetruecolor($image_new_width, $image_new_height);
			imagecopyresampled($my_new_temp_image, $my_temp_image, 0, 0, 0, 0, $image_new_width, $image_new_height, $image_width, $image_height);
	
		return $my_new_temp_image;
		return $image_new_width;
		return $image_new_height;
	}
	
	function image_thumbnail($my_temp_image, $image_width, $image_height){
		$image_thumbnail = imagecreatetruecolor(100, 100);
		imagecopyresampled(($image_thumbnail, $my_temp_image, 0, 0, 0, 0, 100, 100, $image_width, $image_height);
	}

?>