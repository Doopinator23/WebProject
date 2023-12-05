<?php
	include '../dbconn.php';
	$title = $_POST['title'];
	$rating = $_POST['rating'];

	$data = [];
	$usernames = [];
	$titles = [];
	$ratings = [];
	$opinions = [];
	$stmt = null;

	if(!empty($title))
	{
		$sql = "SELECT * FROM Reviews WHERE Title = :ti";
		$stmt = $connect->prepare($sql);
		$stmt->bindParam(':ti', $title);
		$stmt->execute();
		if($stmt->rowCount() > 0)
		{
		    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		    {
		        $usernames[] = $row['Username'];
		        $titles[] = $row['Title'];
		        $ratings[] = $row['Rating'];
		        $opinions[] = $row['Opinion'];
		    }                
		}
		else
		{
		    echo "No results found!";
		}

		$connect = null;
		$data['Usernames'] = $usernames;
		$data['Titles'] = $titles;
		$data['Ratings'] = $ratings;
		$data['Opinions'] = $opinions;
		$data['success'] = true;
	}

	else if($rating != 0)
	{
		$sql = "SELECT * FROM Reviews WHERE Rating = :ra";
		$stmt = $connect->prepare($sql);
		$stmt->bindParam(':ra', $rating);
		$stmt->execute();
		if($stmt->rowCount() > 0)
		{
		    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		    {
		        $usernames[] = $row['Username'];
		        $titles[] = $row['Title'];
		        $ratings[] = $row['Rating'];
		        $opinions[] = $row['Opinion'];
		    }                
		}
		else
		{
		    echo "No results found!";
		}

		$connect = null;
		$data['Usernames'] = $usernames;
		$data['Titles'] = $titles;
		$data['Ratings'] = $ratings;
		$data['Opinions'] = $opinions;
		$data['success'] = true;
	}
	else
	{
		$sql = "SELECT * FROM Reviews WHERE Title = :ti AND Rating = :ra";
		$stmt = $connect->prepare($sql);
		$stmt->bindParam(':ti', $title);
		$stmt->bindParam(':ra', $rating);

		
		$stmt->execute();
		if($stmt->rowCount() > 0)
		{
		    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		    {
		        $usernames[] = $row['Username'];
		        $titles[] = $row['Title'];
		        $ratings[] = $row['Rating'];
		        $opinions[] = $row['Opinion'];
		    }                
		}
		else
		{
		    echo "No results found!";
		}

		$connect = null;
		$data['Usernames'] = $usernames;
		$data['Titles'] = $titles;
		$data['Ratings'] = $ratings;
		$data['Opinions'] = $opinions;
		$data['success'] = true;
	}

	echo json_encode($data);

?>
