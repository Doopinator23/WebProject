<?php
	session_start();
	$errors = [];
	$data = [];
	$current_password = $_POST["current_password"];
	$new_password = $_POST["new_password"];
	$verify_new_password = $_POST["verify_new_password"];

	if (empty($current_password)) 
	{
	    $errors['current_password'] = 'Current password is required.';
	}

	if (empty($new_password)) 
	{
	    $errors['new_password'] = 'New password is required.';
	}

	if (empty($verify_new_password)) 
	{
	    $errors['verify_new_password'] = 'Re-enter password is required.';
	}

	if (!empty($errors)) 
	{
	    $data['success'] = false;
	    $data['errors'] = $errors;
	}

	else
	{
		include '../dbconn.php';
		$username = $_SESSION['username'];


		$sql = 'SELECT Password FROM Accounts WHERE Username = :un';
		$statement = $connect->prepare($sql);

		$statement->bindParam(':un', $username);
		$statement->execute();

		$doesPasswordMatch = true;
		while($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			if(password_verify($current_password, $row['Password']))
			{
				$doesPasswordMatch = true;
			}
			else
			{
				$doesPasswordMatch = false;
				$errors['current_password'] = "Password does not match.";
			}
		}

		if(!$doesPasswordMatch)
		{
			$data['success'] = false;
	    	$data['errors'] = $errors;
		}

		else
		{
			$doNewPasswordsMatch = $new_password === $verify_new_password;
			if($doNewPasswordsMatch == false)
			{
				$data['success'] = false;
		    	$errors['new_password'] = 'New passwords do not match.';
		    	$data['errors'] = $errors;
			}
			else
			{
				$data['success'] = true;
		    	$data['message'] = 'Success! Your password has been changed.';

				$sql = 'UPDATE Accounts SET Password = :pw WHERE Username = :un';
				$statement = $connect->prepare($sql);

				$hash_new_password = password_hash($new_password, PASSWORD_BCRYPT);

				$statement->bindParam(':pw', $hash_new_password);
				$statement->bindParam(':un', $username);
				$statement->execute();
			}
		}
	}

	echo json_encode($data);
?>