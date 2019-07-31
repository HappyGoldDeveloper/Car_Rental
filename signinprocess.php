<?php

require 'session.php';


$_SESSION['userId'] = "";

$errorMessage = "";
$login ="";
$fail = True;

$username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (!(empty($username) || empty($password)))
{
	$query = "SELECT * FROM Users WHERE username = '$username'";
	$statement = $db->prepare($query);
	$statement->execute();
	$row = $statement->fetch();
	// $_SESSION['password'] = $row['password'];
	if($statement->rowCount() != 0)
	{



		$dbPassword = $row['password'];

		$enteredPassword ='yt635343guy6753ry'.$password .'jwdnflln73463746klelknlk';
		$enteredPassword = hash('sha512',$enteredPassword);


		if ($enteredPassword == $dbPassword) 
		{
			$_SESSION['userId'] = $row['userId'];
			header("Location:rides.php?success=yes");
		}
		else
		{
			header("Location:login.php?signup=password");
			// $login = "Login Failed!";
			// $fail = False;
		}
			
	}
	else
	{
		header("Location:login.php?signup=fail");
			// $login = "Login Failed!";
			// $fail = False;
	}
}
else
{
	header("Location:login.php?signup=empty");
	// $login= "Username and Password cannot be empty!";
	// $fail = False;
}


?>