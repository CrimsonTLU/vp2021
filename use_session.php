<?php
	//alustame sessiooni
	//set_session_cookie_params();
    //session_start();
	require_once("classes/SessionManager.class.php");
	SessionManager::sessionStart("vp", 0, "/~chrhin/vp2021", "greeny.cs.tlu.ee");
    //kas on sisselogitud
    if(!isset($_SESSION["user_id"])){
        header("Location: page2.php");
    }
    //väljalogimine
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page2.php");
    }
?>