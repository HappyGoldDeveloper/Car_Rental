<?php


require 'session.php';
$error = "";

$admin = "";

if(isset($_SESSION['admin']))
{
	$admin = $_SESSION['admin'];
}
$userID = "";

if(isset($_SESSION['userId']))
{
	$userID = $_SESSION['userId'];
}



if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['text']) || empty($_POST['title']))
{
	$error = "Empty Fields!";
}
else
{
	if (!(filter_input(INPUT_POST,"email", FILTER_VALIDATE_EMAIL))) 
	{
		echo "Invalid Email";
	}
	else
	{
		$email = $_POST['email'];
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$query = "INSERT INTO Feedback (feedbackId,name,title,time,text,email) VALUES ('',:name,:title,now(),:text,:email)";
		$statement = $db->prepare($query);
		$statement->bindValue(':name',$name);
 		$statement->bindValue(':title',$title);
 		$statement->bindValue(':text',$text);
 		$statement->bindValue(':email',$email);
 		$statement->execute();

	}
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

	<?php if (!(isset($_SESSION['admin']))): ?>
	<a href="signup.php">Sign up</a>
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
				<label>Name</label>
				<input type="text" name="name">
			</li>
			<li>
				<label>Title</label>
				<input type="text" name="title">
			</li>
			<li>
				<label>Email</label>
				<input type="Email" name="email">
			</li>
			<li>
				<label>Suggestion</label>
				<textarea cols="6" name="text">
					
				</textarea>
				<label><?=$error?></label>
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