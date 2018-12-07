<?php

require 'session.php';
$admin = "";
$nomatch = "";

if(isset($_SESSION['admin']))
{
	$admin = $_SESSION['admin'];
}

if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['confirmpassword']))
{
	$nomatch = "Empty fields";
}
else
{
	if (($_POST['password']) == ($_POST['confirmpassword'])) 
	{
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = 'yt635343guy6753ry'.$password .'jwdnflln73463746klelknlk';
		$password = hash('sha512',$password);
		$query = "INSERT INTO Users (userId,username,password,admin) values ('',:username,:password,'0')";
		$statement = $db->prepare($query);
		$statement->bindValue(':username',$username);
		$statement->bindValue(':password',$password);
		$statement->execute();

		echo $password;
 	}
 	else
 	{
 		$nomatch = "Passwords don't match"; 
 	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>SIGNUP</title>
</head>
<body>
	<header>SIGNUP PAGE</header>
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
	</div>
	<form action="#" method="POST">
		<ul>
			<li>
				<label>Username:</label>
				<input type="text" name="username" placeholder="enter username here">
			</li>
			<li>
				<label>Password:</label>
				<input type="text" name="password">
			</li>
			<li>
				<label>Confirm Password:</label>
				<input type="text" name="confirmpassword">
				<h3><?=$nomatch?></h3>
			</li>
			<li>
				<button>Sign up</button>
			</li>
		</ul>
	</form>
</body>
</html>