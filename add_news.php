<?php
    require_once("use_session.php");
	
    require_once("../../config.php");
    require_once("fnc_photoupload.php");
	require_once("fnc_general.php");
	require_once("fnc_news.php");
	require_once("classes/Photoupload.class.php");
	
    $news_notice = null;
	
	$expire = new DateTime("now");
	$expire->add(new DateInterval("P7D"));
	$expire_date = date_format($expire, "Y-m-d");
      
	$normal_photo_max_width = 600;
    $normal_photo_max_height = 400;
	$thumbnail_width = $thumbnail_height = 100;
	
	$photo_file_name_prefix = "vp_";
	$photo_file_size_limit = 1.2 * 1024 * 1024;
	$allowed_photo_types = ["image/jpeg", "image/png"];
	$image_size_ratio = 1;
    $file_type = null;
    $file_name = null;
	$alt_text = null;
	$privacy = 1;
	
    $photo_filename_prefix = "vpnews_";
    $photo_upload_size_limit = 1024 * 1024;
	
	$news_title = null;
	$news_contents = null;
	$news_photo = null;
    
    if(isset($_POST["news_submit"])){
        //kui uudisele on valitud foto, siis see salvestage esimesena ja lisage esimesena ka andmetabelisse (uudisefotodel eraldi andmetabel).
        //siis lisate uudise koos uudise pealkirja, aegumise ja foto id-ga eraldi andmetabelisse.
        //Andmebaasi salvestamisel saab pärast execute() käsku just salvestatud kirje id kätte:
        //$muutuja = $conn->insert_id;
        //uudise sisu peaks läbima funktsiooni test_input(uudis) (fnc_general.php).
        //seal on htmlspecialchars() funktsioon, mis teisendab html märgised (näiteks:  < --> &lt;   )
        //tagasi saab: htmlspecialchars_decode(uudis andmebaasist).
        
        //aegumistähtaja saate date inputist.
        //uudiste näitamisel võrdlete SQL lauses andmebaasis olevat aegumiskuupäeva tänasega
        //$today = date("Y-m-d");
        //SQL-is    WHERE expire >= ?
		
		if(isset($_POST["news_heading_input"]) and !empty($_POST["news_heading_input"])){
			$news_title = test_input(filter_var($_POST["news_heading_input"], FILTER_SANITIZE_STRING));
		}else{
			$news_notice = "Sisestage korrektne pealkiri! ";
		}
		if(isset($_POST["news_input"]) and !empty($_POST["news_input"])){
			$news_title = test_input(filter_var($_POST["news_input"], FILTER_SANITIZE_STRING));
		}else{
			$news_notice .= "Sisestage korrektne sisu!";
		}
		
		if(isset($_FILES["photo_input"]["tmp_name"]) and !empty($_FILES["photo_input"]["tmp_name"])){
			$image_file_name = $_FILES["photo_input"]["tmp_name"];
			$user_id = $_SESSION["user_id"];
			$news_notice = store_news_photo($image_file_name, $user_id);
		}
		$news_notice = null;
		
		if(empty($news_notice)){
			$news_title = $_POST["news_heading_input"];
			$news_contents = $_POST["news_input"];
			
			$news_notice = store_news_data($user_id, $news_title, $news_contents, $expire_date);
		}
		
	}
	
	
	$to_head = '<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>' ."\n";
	
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
    <h2>Uudise lisamine</h2>
	<hr>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"enctype="multipart/form-data">
		<label for="news_heading_input">Uudise pealkiri</label>
		<br>
		<textarea id="news_heading_input" name="news_heading_input" value="<?php echo $news_title; ?>"></textarea>
		<br>
		<label for="news_input">Uudise sisu</label>
		<br>
		<textarea id="news_input" name="news_input" value="<?php echo $news_contents; ?>"></textarea>
		<script>CKEDITOR.replace("news_input");</script>
		<br>
		<label for="expire_input">Uudis aegub pärast:</label>
		<input type="date" id="expire_input" name="expire_input" value="<?php echo $expire_date; ?>">
		<br>
		<label for="photo_input">Vali pildifail</label>
		<input type="file" name="photo_input" id="photo_input">	
		<br>
		<input type="submit" name="news_submit" id="news_submit" value="Salvesta uudis">		
	</form>
	<span><?php echo $news_notice; ?></span>
	
</body>
</html>