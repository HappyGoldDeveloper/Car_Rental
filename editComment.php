<?php

require 'session.php';
$admin = "";
	
	if (isset($_GET['id'])) 
	{
		//$title = $_GET['title'];
	$id = $_GET['id'];
	//$date = $_GET['date'];
	}

	$query = "SELECT * FROM Suggestion WHERE SuggestionId = '$id'";
    $statement = $db->prepare($query);
    $statement->execute();
    $new = $statement->fetch();

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
<form action="processEditComment.php?id=<?=$id?>" method="post">
	<div>
		<ul>
			<li>
				<label>Title</label>
				<input type="text" name="title"  value="<?=$new['Title']?>">
			</li>
			<li>
				<label>Suggestion</label>
				<input type="text" name="text" value="<?=$new['Comment']?>">

			</li>
			<li>
				<button name="update">Update</button>
				<button name="delete">Delete</button>
			</li>
		</ul>
	</div>
</form>
</section>
<footer>
</footer>
</body>
</html>