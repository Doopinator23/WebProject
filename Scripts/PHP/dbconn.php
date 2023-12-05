<?php
	try
	{
		$connect = new PDO("mysql:host=localhost;dbname=webdesign", "damian", "gapves-3rersa-Kurfom");
	}

	catch (PDOException $e)
	{
		die($e);
	}
?>