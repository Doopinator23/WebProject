<?php
    session_start();
    include "twig.php";
    include "header-check.php";

    echo $twig->render("submit-review.html", ["sessionActive" => $sessionStarted, "username" => $username]);
?>