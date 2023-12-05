<?php
	session_start();
	include "twig.php";
	include "header-check.php";

	echo $twig->render("index.html", ["sessionActive" => $sessionStarted, "username" => $username]);
?>