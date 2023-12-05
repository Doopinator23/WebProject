<?php
	session_start();
	include "twig.php";
	include "header-check.php";
	echo $twig->render("shows.html", ["sessionActive" => $sessionStarted, "username" => $username]);
?>