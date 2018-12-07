<?php

require 'session.php';
$admin = "";

if(isset($_SESSION['admin']))
{
	$admin = $_SESSION['admin'];
}


?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<title>F.A.L.T.U Rentals</title>
	<style type="text/css">
			header
			{
				background-color: #000000;
			}
			#logo
			{
				border-radius: 100px;
				height: 200px;

			}
			body
			{
				color: rgb(213, 218, 226);				
			}

	</style>
</head>
<body>
<header>
	<img id="logo" src="images/logo.jpg" alt="logo">
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
	<div>
		
	</div>
</section>
<footer>
	
</footer>
</body>
</html>


