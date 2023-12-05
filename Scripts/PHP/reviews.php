<?php
	session_start();
	include "dbconn.php";
	include "twig.php";
    include "header-check.php";

    $sql = "SELECT * FROM Reviews";
    $statement = $connect->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $connect = null;

	echo $twig->render("reviews.html", ["sessionActive" => $sessionStarted, "username" => $username, "reviews" => $result]);
?>