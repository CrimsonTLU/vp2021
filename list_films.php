<?php
	require_once("../../config.php");
	require_once("fnc_films.php");
	//echo $server_host; - kontrollisin, kas sai info kätte
	$author_name = "Christian Hindremäe";
	$film_html = null;
	$film_html = read_all_films();
	
	require("page2_header.php");
?>

<body>
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine, muudatused tehtud kodus</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
	<h2>Eesti filmid</h2>
	<?php echo $film_html ?>

</body>
</html>