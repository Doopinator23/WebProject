<?php
	session_start();
	include "twig.php";
	include "header-check.php";
	echo $twig->render("movies.html", ["sessionActive" => $sessionStarted, "username" => $username]);
?>