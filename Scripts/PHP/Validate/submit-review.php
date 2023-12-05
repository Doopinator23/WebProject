<?php
	//grab data from form
	session_start();
	$errors = [];
	$data = [];
	$title = $_POST['title'];
	$rating = $_POST['rating'];
	$opinion = $_POST['opinion'];

	//check for errors in the inputs
	if (empty($title))
	{
		$errors['title'] = "Title is required.";
	}
	if (empty($rating)) 
	{
	    $errors['rating'] = 'Rating is required.';
	}

	if (empty($opinion)) 
	{
	    $errors['opinion'] = 'Content is required.';
	}

	if (!empty($errors)) //if errors are present, send an unsuccessful call to ajax
	{
	    $data['success'] = false;
	    $data['errors'] = $errors;
	}

	else
	{
		include '../dbconn.php';
		try
		{
			//prepare the query
			$sql = "INSERT INTO Reviews (Username, Title, Rating, Opinion) VALUES (:us, :ti, :ra, :op)";
			$stmt = $connect->prepare($sql);

			//bind the parameters from the form inputs
			$stmt->bindParam(':us', $_SESSION['username']);
			$stmt->bindParam(':ti', $title);
			$stmt->bindParam(':ra', $rating);
			$stmt->bindParam(':op', $opinion);

			//execute the query
			$stmt->execute();

			//destroy database connection
			$connect = null;

			//send a successful response to json
			$data['success'] = true;
			$data['message'] = 'Success! Your review has been submitted.';
		}
		catch(PDOException $e) //in case of exception, log and display error, then kill the connection
		{
			error_log("Error: " . $e->getMessage());
			$data['success'] = false;
			$data['message'] = 'An error occurred while processing your request. Please try again later.';
		}
		finally
		{
			$connect = null;
		}
		
	}

	echo json_encode($data);
?>