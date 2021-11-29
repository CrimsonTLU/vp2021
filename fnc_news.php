<?php
	$database = "if21_chr_hin";
	
	function store_news_photo($image_file_name, $user_id){
		$news_notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("INSERT INTO vprg_newsphotos (filename, userid) VALUES (?, ?)");
		echo $conn->error;
		$stmt->bind_param("si", $image_file_name, $user_id);
		if($stmt->execute()){
		  $news_notice .= "Foto lisati andmebaasi!";
		} else {
		  $news_notice = "Foto lisamisel andmebaasi tekkis tõrge: " .$stmt->error;
		}
		
		$stmt->close();
		$conn->close();
		return $news_notice;
	}
	
	function store_news_data($user_id, $news_title, $news_content, $expire_date){
		$news_notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("INSERT INTO vprg_news (userid, title, content, expire) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("isss", $user_id, $news_title, $news_content, $expire_date);
		if($stmt->execute()){
		  $news_notice .= "Uudis lisati andmebaasi!";
		} else {
		  $news_notice = "Uudise lisamisel andmebaasi tekkis tõrge: " .$stmt->error;
		}
		
		$stmt->close();
		$conn->close();
		return $news_notice;
	}
?>