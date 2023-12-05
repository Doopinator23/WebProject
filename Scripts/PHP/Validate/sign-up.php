<?php
	$errors = [];
	$data = [];

	$username = $_POST['username'];
	$password = $_POST['password'];
	$gender = $_POST['gender'];
	$phone = $_POST['pnumber'];

	if (empty($username)) 
	{
	    $errors['username'] = 'Username is required.';
	}

	if (empty($password)) 
	{
	    $errors['password'] = 'Password is required.';
	}

	if (($password != $_POST['verifypassword']) || (empty($_POST['verifypassword'])))
	{
		$errors['verifypassword'] = 'Passwords do not match.';
	}

	if (empty($gender)) 
	{
	    $errors['gender'] = 'Gender is required.';
	}

	if (empty($phone)) 
	{
	    $errors['pnumber'] = 'Phone is required.';
	}

	if (!empty($errors)) 
	{
	    $data['success'] = false;
	    $data['errors'] = $errors;
	}
	
	else 
	{
		include '../dbconn.php';

		$sql = "SELECT Username FROM Accounts";
		$statement = $connect->prepare($sql);
		$statement->execute();
		$isDuplicate = false;

		while($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			if($username == $row['Username'])
			{
				$errors['username'] = 'Username has already been found in the database. Use a different one.';
				$isDuplicate = true;
			}
		}

		if($isDuplicate)
		{
			$data['success'] = false;
	    	$data['errors'] = $errors;
		}

		else
		{
			$data['success'] = true;
		    $data['message'] = 'Success! Your account has been successfully created.';

			$encryptedpass = password_hash($password, PASSWORD_BCRYPT);
			try
			{
				$sql = "INSERT INTO Accounts (Username, Password, Gender, PhoneNumber) VALUES (:us, :pa, :ge, :ph)";
				$stmt = $connect->prepare($sql);

				$stmt->bindParam(':us', $username);
				$stmt->bindParam(':pa', $encryptedpass);
				$stmt->bindParam(':ge', $gender);
				$stmt->bindParam(':ph', $phone);

				$stmt->execute();
			}

			catch(PDOException $e)
			{
				echo $e;
			}
		}

		$connect = null;
	}
	echo json_encode($data);
?>