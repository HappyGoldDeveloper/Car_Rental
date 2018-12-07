<?php

require 'session.php';


$_SESSION['userId'] = "";

$errorMessage = "";
$login =" ";

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
			header("Location:rides.php");
		}
		else
		{
			$login = "LOGIN NOT SUCCESSFULL";
		}
			
	}
	else
	{
			$login = "LOGIN NOT SUCCESSFULL AT ALL";
	}
}
else
{
	$errorMessage= "Username and Password cannot be empty!";
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<header>LOGIN PAGE</header>
	<div>
	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="rides.php">Rides</a></li>
			<?php if (isset($_SESSION['admin'])): ?>
			<li><a href="create.php">Add New Ride</a></li>
			<?php endif; ?>
			<li><a href="contact.php">Contact</a></li>
		</ul>
	</nav>
	<?php if (!(isset($_SESSION['admin']))): ?>
	<a href="signup.php">Sign up</a>
	<?php endif; ?>
	</div>
	<form action="#" method="POST">
		<ul>
			<li>
				<label>Username:</label>
				<input type="text" name="username">
			</li>
			<li>
				<label>Password:</label>
				<input type="text" name="password">
				<label><?=$errorMessage?></label>
				<label><?=$login?></label>
			</li>
			<li>
				<button>LOGIN</button>
			</li>
		</ul>
	</form>
</body>
</html>