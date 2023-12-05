<?php
	include 'dbconn.php'; //Call database connection

	$sql = "SELECT Name, Surname, Saying FROM UserSayings WHERE ID = :id"; //Query to select items from UserSayings

	$statement = $connect->prepare($sql); //Use the value depending on which image is clicked
	$statement->bindParam(":id", $_GET['q']);
	$statement->execute();
	
	$result = $statement->fetch(PDO::FETCH_ASSOC); //Fetch results

	$uname = $result['Name']; //Place rows in variables and output them
	$usurname = $result['Surname'];
	$usaying = $result['Saying'];

	echo "<p>\"$usaying\"</p>";
	echo "<p class='signature'>- $uname $usurname</p>";
?>