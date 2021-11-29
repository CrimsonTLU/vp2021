<?php
    require_once("use_session.php");
	
/* 	//testin klassi
	require_once("classes/Test.class.php");
	$test_object = new Test(6);
	echo " Teadaolev number: " .$test_object->known_number; //dollarimärki ei panda
	$test_object->reveal();
	unset($test_object); */
	
	//küpsised, peavad olema enne HTMLi
	//expire==0: kustutakse peale brauseri sulgemist. Praegune hetk + sekundid
	//time() + sekundid, ööpäevas on 86400 sekundit (60*60*24)
	//httponly - pääseb ligi ainult läbi veebi, mitte arvutist
	setcookie("vpvisitor", $_SESSION["first_name"] ." " .$_SESSION["last_name"], time() + (86400 * 6), "/~chrhin/vp2021", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
	$last_visitor = "pole teada";
	if(isset($_COOKIE["vpvisitor"]) and !empty($_COOKIE["vpvisitor"])){
		$last_visitor = $_COOKIE["vpvisitor"];
	}
	//cookie kustutamine, pannakse aegumine minevikus
	//time() - 3600
    
	require("page2_header.php");
?>
	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
		<?php echo "<p>Eelmine külastaja " .$last_visitor ."</p> \n" ?>
	<hr>
    <ul>
        <li><a href="?logout=1">Logi välja</a></li>
		<li><a href="list_films.php">Filmide nimekirja vaatamine</a> versioon 1</li>
		<li><a href="add_films.php">Filmide lisamine andmebaasi</a> versioon 1</li>
		<li><a href="user_profile.php">Kasutajaprofiil</a></li>
		<li><a href="movie_relations.php">Filmi, isiku jms seoste loomine</a></li>
		<li><a href="gallery_photo_upload.php">Galeriipiltide üleslaadimine</a></li>
		<li><a href="gallery_public.php">Sisseloginud kasutajatele nähtavate fotode galerii</a></li>
		<li><a href="gallery_own.php">Minu fotode galerii</a></li>
		<li><a href="add_news.php">Uudiste lisamine</a></li>
    </ul>
</body>
</html>