<?php

require 'session.php';
$admin = "";
$error ="";
$id = "";

$userID = "";
if(isset($_SESSION['userId']))
{
	$userID = $_SESSION['userId'];
}


if(isset($_SESSION['admin']))
{
	$admin = $_SESSION['admin'];
}

if (isset($_GET['id'])) 
{
		//$title = $_GET['title'];
	$id = $_GET['id'];
	//$date = $_GET['date'];
}

if(empty($_POST['title']) || empty($_POST['reviews']))
{
		$error = "Empty Fields";
}
else
{
	$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$text = filter_input(INPUT_POST, 'reviews', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$query = "INSERT INTO Suggestion (SuggestionId,VehicleId,UserId,Comment,Date,Title) VALUES ('',:VehicleId,:UserId,:comment,now(),:title)";
	$statement = $db->prepare($query);
	$statement->bindValue(':VehicleId',$id);
 	$statement->bindValue(':UserId',$userID);
 	$statement->bindValue(':comment',$text);
 	$statement->bindValue(':title',$title);
 	$statement->execute();

 	header('location:rides.php');

}

?>



<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script src="//cdn.ckeditor.com/4.6.0/full/ckeditor.js"></script>
	<title>F.A.L.T.U Rentals</title>
</head>
<body>
<header>
	<img src="images/logo.jpg">
</header>
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
			<?php if (isset($_SESSION['admin'])): ?>
			<?php if ($admin == 1): ?>
			<li><a href="create.php">Add New Ride</a></li>
				<?php endif; ?>
			<?php endif; ?>
			<li><a href="contact.php">Contact</a></li>
		</ul>
	</nav>
</div>
<section>
<form action="#" method="post">
	<div>
		<ul>
			<li>
				<label>Title</label>
				<input type="text" name="title">
			</li>
			<li>
				<label>Suggestion</label>
				<textarea id="ckeditor" name="reviews" rows="5" cols="170"></textarea>
				<script>
                 CKEDITOR.replace('ckeditor');
                 </script>
			</li>
			<li>
				<button type="submit">Submit</button>
			</li>
		</ul>
	</div>
</form>
</section>
<footer>
</footer>
</body>
</html>