<?php
    //alustame sessiooni
    session_start();
    //kas on sisselogitud
    if(!isset($_SESSION["user_id"])){
        header("Location: page2.php");
    }
    //väljalogimine
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page2.php");
    }
	
    require_once("../../config.php");
    require_once("fnc_photoupload.php");
	require_once("fnc_general.php");
	require_once("classes/Photoupload.class.php");
	
	$photo_error = null;
    $photo_upload_notice = null;
      
	$normal_photo_max_width = 600;
    $normal_photo_max_height = 400;
	$thumbnail_width = $thumbnail_height = 100;
	
	$photo_file_name_prefix = "vp_";
	$photo_file_size_limit = 1.2 * 1024 * 1024;
	$image_size_ratio = 1;
    $file_type = null;
    $file_name = null;
	$alt_text = null;
	$privacy = 1;
	$watermark_file = "pics/vp_logo_color_w100_overlay.png";
	
	$file_type = null;
    $file_name = null;
    $alt_text = null;
    $privacy = 1;
    $photo_filename_prefix = "vp_";
    $photo_upload_size_limit = 1024 * 1024;
    $photo_size_ratio = 1;
    
    if(isset($_POST["photo_submit"])){
        //var_dump($_POST);
        //var_dump($_FILES);
        
        if(isset($_FILES["photo_input"]["tmp_name"]) and !empty($_FILES["photo_input"]["tmp_name"])){
            $image_check = getimagesize($_FILES["photo_input"]["tmp_name"]);
            if($image_check !== false){
                if($image_check["mime"] == "image/jpeg"){
                    $file_type = "jpg";
                }
                if($image_check["mime"] == "image/png"){
                    $file_type = "png";
                }
                if($image_check["mime"] == "image/gif"){
                    $file_type = "gif";
                }
                
                
                
            } else {
                $photo_upload_notice .= "Valitud fail ei ole pilt!";
            }
        } else {
			$photo_upload_notice .= "Pilt on valimata!";
		}
		
		if(empty($photo_upload_notice) and $_FILES["photo_input"]["size"] > $photo_file_size_limit){
			$photo_upload_notice = "Pildifail on liiga suur!";
		}
		
		//kas alt tekst on
            if(isset($_POST["alt_input"]) and !empty($_POST["alt_input"])){
                $alt_text = test_input(filter_var($_POST["alt_input"], FILTER_SANITIZE_STRING));
/*                 if(empty($alt_text)){
                    $photo_error .= "Alternatiivtekst on lisamata!";
                } */
            }
			
			//kas on privaatsus
			if(isset($_POST["privacy_input"]) and !empty($_POST["privacy_input"])){
				$privacy = filter_var($_POST["privacy_input"], FILTER_VALIDATE_INT);
			}
			if(empty($privacy)){
				$photo_error . " Privaatsus on määramata!";
			}
			
			$photo_upload = new Photoupload($_FILES["photo_input"], $file_type);
			
            
            if(empty($photo_error)){
                //teen ajatempli
                $time_stamp = microtime(1) * 10000;
                
                //moodustan failinime, kasutame eesliidet
                $file_name = $photo_filename_prefix .$time_stamp ."." .$file_type;
                
                //suuruse muutmine
                //$my_new_temp_image = resize_photo($my_temp_image, $normal_photo_max_width, $normal_photo_max_height);
                $photo_upload->resize_photo($normal_photo_max_width, $normal_photo_max_height);
                                
                //lisan vesimärgi
				//$my_new_temp_image = add_watermark($my_new_temp_image, $watermark_file);
                $photo_upload->add_watermark($watermark_file);
                
                //salvestan
                //$photo_upload_notice = "Vähendatud pildi " .save_image($my_new_temp_image, $file_type, $photo_normal_upload_dir .$file_name);
                $photo_upload_notice = "Vähendatud pildi " .$photo_upload->save_image($photo_upload_normal_dir .$file_name);
                //imagedestroy($my_new_temp_image);
				
				//teen pisipildi
				//$my_new_temp_image = resize_photo($my_temp_image, $thumbnail_width, $thumbnail_height, false);
                $photo_upload->resize_photo($thumbnail_width, $thumbnail_height);
                //$photo_upload_notice .= " Pisipildi " .save_image($my_new_temp_image, $file_type, $photo_thumbnail_upload_dir .$file_name);
                $photo_upload_notice = "Pisipildi " .$photo_upload->save_image($photo_upload_thumb_dir .$file_name);
                //imagedestroy($my_new_temp_image);
                
                //imagedestroy($my_temp_image);
                
                //kopeerime pildi originaalkujul, originaalnimega vajalikku kataloogi
				$photo_upload_notice .= $photo_upload->move_orig_photo($photo_orig_upload_dir .$file_name);
                /* if(move_uploaded_file($_FILES["photo_input"]["tmp_name"], $photo_upload_orig_dir .$file_name)){
                    $photo_upload_notice .= " Originaalfoto laeti üles!";
                    //$photo_upload_notice = store_person_photo($file_name, $_POST["person_for_photo_input"]);
                } else {
                    $photo_upload_notice .= " Foto üleslaadimine ei õnnestunud!";
                } */
				
				$photo_upload_notice .= " " .store_photo_data($file_name, $alt_text, $privacy);
				$alt_text = null;
				$privacy = 1;
            
        
            unset($photo_upload);
			
         }else {
            $photo_error = "Pildifaili pole valitud!";
        }
        
        if(empty($photo_upload_notice)){
			$photo_upload_notice = $photo_error;
		}
    }

            
            //if(move_uploaded_file($_FILES["photo_input"]["tmp_name"], $photo_upload_orig_dir .$file_name)){
  
	
    require("page2_header.php");
?>
	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
    <ul>
        <li><a href="?logout=1">Logi välja</a></li>
		<li><a href="home.php">Avaleht</a></li>
		<li><a href="list_films.php">Filmide nimekirja vaatamine</a> versioon 1</li>
    </ul>
	<hr>
    <h2>Galeriipiltide üleslaadimine</h2>
	<hr>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"enctype="multipart/form-data">
		<label for="photo_input">Vali pildifail</label>
		<input type="file" name="photo_input" id="photo_input">	
		<br>
		<label for"alt_input">Alternatiivtekst (alt):</label>
		<input type="text" name="alt_input" id="alt_input" placeholder="alternatiivtekst..." value="<?php echo $alt_text; ?>">
		<br>
		<input type="radio" name="privacy_input" id="privacy_input_1" value="1" <?php if($privacy == 1) {echo " checked";}?>>
		<label for="privacy_input_1">Privaatne (ainult mina näen)</label>
		<br>
		<input type="radio" name="privacy_input" id="privacy_input_2" value="2" <?php if($privacy == 2) {echo " checked";}?>>
		<label for="privacy_input_2">Sisseloginud kasutajatele</label>
		<br>
		<input type="radio" name="privacy_input" id="privacy_input_3" value="3" <?php if($privacy == 3) {echo " checked";}?>>
		<label for="privacy_input_3">Avalik</label>
		<br>
		
		<input type="submit" name="photo_submit" value="Lae pilt üles">
		
	</form>
	<span><?php echo $photo_upload_notice; ?></span>
	
</body>
</html>