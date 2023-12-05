<?php
	require_once '../../vendor/autoload.php';
	$loader = new \Twig\Loader\FilesystemLoader('../../Templates');
	$twig = new \Twig\Environment($loader);
?>