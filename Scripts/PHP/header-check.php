<?php
	$sessionStarted = isset($_SESSION['username']);
	$username = "";
	if($sessionStarted)
	{
		$username = $_SESSION['username'];
	}
?>