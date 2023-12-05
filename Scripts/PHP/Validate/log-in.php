<?php
	session_start();
	$errors = [];
	$data = [];
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username)) 
	{
	    $errors['username'] = 'Username is required.';
	}

	if (empty($password)) 
	{
	    $errors['password'] = 'Password is required.';
	}

	if (!empty($errors)) 
	{
	    $data['success'] = false;
	    $data['errors'] = $errors;
	}

	else 
	{
		include '../dbconn.php';
		try
		{
			$sql = "SELECT Username, Password FROM Accounts WHERE Username = :us";
			$statement = $connect->prepare($sql);
			$statement->bindParam(':us', $username);
			$statement->execute();

			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

			if(empty($result))
			{
				$errors['username'] = 'Username does not exist.';
				$data['success'] = false;
		    	$data['errors'] = $errors;
			}

			else
			{
				$password_hash = $result[0]['Password'];
				$is_password_matching = password_verify($password, $password_hash);
				if($is_password_matching)
				{
					$data['success'] = true;
			    	$data['message'] = 'Welcome. Redirecting you to the homepage...';
			    	$_SESSION["username"] = $username;
				}

				else
				{
					$errors['password'] = 'Password is wrong.';
					$data['success'] = false;
			    	$data['errors'] = $errors;
				}

			}
		}
		catch(PDOException $e)
		{
			echo $e;
		}
		

		$connect = null;

	}

	echo json_encode($data);
?>