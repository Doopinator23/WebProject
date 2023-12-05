<?php
	include '../dbconn.php'; //database connection
	$title = $_POST['title'];
	$rating = $_POST['rating'];

	$data = [];
	$parameters = []; //Holds parameters depending on which inputs are populated by the user
	$usernames = [];
	$titles = [];
	$ratings = [];
	$opinions = [];

	try
	{
		$sql = "SELECT * FROM Reviews WHERE 1"; //Prepare query

		if(!empty($title))
		{
			$sql .= " AND Title LIKE :ti";
			$parameters[":ti"] = $title;
		}

		if($rating != 0)
		{
			$sql .= " AND Rating = :ra";
			$parameters[":ra"] = $rating;
		}

		$statement = $connect->prepare($sql);

		foreach($parameters as $item => $value) //Bind parameters based on whcih fields are populated
		{
			$statement->bindParam($item, $parameters[$item]);
		}

		$statement->execute();

		if($statement->rowCount() > 0) //if there are rows
		{
		    while($row = $statement->fetch(PDO::FETCH_ASSOC))
		    {
		        $usernames[] = $row['Username'];
		        $titles[] = $row['Title'];
		        $ratings[] = $row['Rating'];
		        $opinions[] = $row['Opinion'];
		    }   
		
			$data['Usernames'] = $usernames;
			$data['Titles'] = $titles;
			$data['Ratings'] = $ratings;
			$data['Opinions'] = $opinions;
			$data['success'] = true;
		}
		else //if there are no rows
		{
			$data["message"] = "No results found.";
			$data["success"] = false;
		}
	}
	catch(PDOException $e)
	{
		$data["message"] = "Error: " . $e->getMessage();
		$data["success"] = false;
	}

	$connect = null; //Kill connection
	echo json_encode($data);
?>
