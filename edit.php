<?php

require 'session.php';

	
	if (isset($_GET['id'])) 
	{

		$id = $_GET['id'];

	}

	$query = "SELECT * FROM Cars WHERE VehicleId = '$id'";
    $statement = $db->prepare($query);
    $statement->execute();
    $new = $statement->fetch();

    $image ="";
    if (isset($_GET['name'])) 
    {
    	$image = $_GET['name'];
    }
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<title>F.A.L.T.U Rentals</title>
</head>
<body>
<header>
	<img src="images/logo.jpg">
</header>
<p>
	<a href="login.php">[login]</a>
</p>
<div>
	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="rides.php">Rides</a></li>
			<li><a href="create.php">Add New Ride</a></li>
			<li><a href="contact.php">Contact</a></li>
			<li>About Us</li>
		</ul>
	</nav>
</div>
<section>
<form action="updateEdit.php?id=<?=$id?>" method="POST">
	<div>
		<ul>
			<li>
				<label>Vehicle Name:</label>
				<input type="text" name="vehiclename" value="<?=$new['VehicleName']?>">
			</li>
			<li>
				<label>Make:</label>
				<input type="text" name="make" value="<?=$new['Make']?>">
			</li>
			<li>
				<label>Year:</label>
				<input type="text" name="year" value="<?=$new['Year']?>">
			</li>
			<li>
				<label>Rental Amount Per Week:</label>
				<input type="text" name="rentalamount" value="<?=$new['Amount']?>">
			</li>
			<li>
				<button name="update"> Update</button>
				<button name="delete"> Delete</button>
			</li>
		</ul>
	</div>
</form>
</section>
<footer>
	
</footer>
</body>
</html>