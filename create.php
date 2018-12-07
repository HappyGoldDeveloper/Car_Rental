<?php

require 'session.php';
$error = "";

$image = "";

if (isset($_GET['name'])) 
{
	$image = $_GET['name'];
}

$captcha = "";
if (isset($_SESSION['code'])) 
{
	$captcha = $_SESSION['code'];
}

if(empty($_POST['vehiclename']) || empty($_POST['make']) || empty($_POST['year']) || empty($_POST['rentalamount']) || empty($_POST['captcha']))
{
	$error ="Empty fields!";
}
else
{
	if ($_POST['captcha'] == $captcha) 
	{
		//require "connect.php";
			$Newimage = $_GET['name'];
			$name = filter_input(INPUT_POST,'vehiclename',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$make = filter_input(INPUT_POST,'make',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$year = filter_input(INPUT_POST,'year',FILTER_VALIDATE_INT);
			$rentalAmount = filter_input(INPUT_POST,'rentalamount',FILTER_VALIDATE_INT);

			$query = "INSERT INTO Cars (VehicleId,VehicleName,Year,Amount,Make,imageName,rented) values ('',:vehiclename,:year,:rentalamount,:make,:Newimage,0)";
			$statement = $db->prepare($query);
		 	$statement->bindValue(':vehiclename',$name);
		 	$statement->bindValue(':year',$year);
		 	$statement->bindValue(':rentalamount',$rentalAmount);
		 	$statement->bindValue(':make',$make);
		 	$statement->bindValue(':Newimage',$Newimage);
		 	$statement->execute();

	 		echo "Database add done";
	 		header('location:rides.php');
 	}

 	else
 	{
 		echo "An Error Occured";
 	}
}


?>



<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<title>F.A.L.T.U Rentals</title>
	<style type="text/css">
		#cap
		{
			height: 30px;
			width: 50px;
		}
	</style>
</head>
<body>
<header>
	<img src="images/logo.jpg">
</header>
<h1><?=$image?></h1>

<?php if (!isset($_SESSION['admin'])): ?>
<p>
	<a href="login.php">[login]</a>
</p>
<?php endif; ?>

<?php if (isset($_SESSION['admin'])): ?>
<p>
	<a href="logout.php">[logout]</a>
</p>
<?php endif; ?>

<div>
	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="rides.php">Rides</a></li>
			<li><a href="create.php">Add New Ride</a></li>
			<li><a href="contact.php">Contact</a></li>
		</ul>
	</nav>
</div>
<section>
<form action="create.php?name=<?=$image?>" method="POST">
	<div>
		<ul>
			<li>
				<label>Vehicle Name:</label>
				<input type="text" name="vehiclename">
			</li>
			<li>
				<label>Make:</label>
				<input type="text" name="make">
			</li>
			<li>
				<label>Year:</label>
				<input type="text" name="year">
			</li>
			<li>
				<label>Rental Amount Per Week:</label>
				<input type="text" name="rentalamount">
				<label><?=$error?></label>
			</li>
			<li>
				<label>Enter Image Text:</label>
				<img src="captcha.php" id="cap" />
      			<input type="text" name="captcha" />
			</li>
			<li>
				<input type="submit" formaction="insertimage.php" value="Upload Image">
             	<label for="image" id="image" name="img"><?=$image?></label>
			</li>
			<li>
				<button>Submit</button>
			</li>
		</ul>
	</div>
</form>
</section>
<footer>
	
</footer>
</body>
</html>