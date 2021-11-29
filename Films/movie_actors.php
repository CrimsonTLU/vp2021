<?php
    require_once("use_session.php");
	
    require_once("../../../config.php");
    require_once("fnc_movie.php");
	require_once("../fnc_general.php");
    
    
	
    require("../page2_header.php");
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
    <h2>Filmi info seoste loomine</h2>
    <h3>Film, isik ja roll</h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">    
        <label for="person_input">Isik: </label>
        <input type="text" name="person_input" id="role_input" placeholder="person" value="<?php echo $person; ?>">
        
        <input type="submit" name="person_movie_relation_submit" value="Salvesta">
    </form>
    <span><?php echo $person_movie_relation_notice; ?></span>
	<hr>
	<h3>Filmitegelase foto lisamine</h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"enctype="multi-part">
		<label for="person_select_for_photo">Isik: </label>
        <select name="person_select" id="person_select_for_photo">
            <option value="" selected disabled>Isik</option>
            <?php echo read_all_person_for_select($person_selected_for_photo); ?>
        </select>
		<input type="file" name="photo_input">
	
		<input type="submit" name="person_photo_submit" value="Lae pilt üles">
	</form>
	<span><?php echo $photo_upload_notice; ?></span>
	
</body>
</html>