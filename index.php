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
	
</head>
<body>
<!-- <header>
	<img id="logo" src="images/logo.jpg" alt="logo">
</header> -->

<header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">FALTU RENTALS</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="rides.php">Rides</a>
      </li>
	<?php if (isset($_SESSION['admin'])): ?>
		<?php if ($admin == 1): ?>	
		<li class="nav-item">
		<a class="nav-link" href="create.php">Manage</a>
		</li>
		<?php endif; ?>
	<?php endif; ?>

      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
    </ul>
    	<?php if (!isset($_SESSION['admin'])): ?>
		<a class="nav-link" href="login.php">Sign In</a>
	<?php endif; ?>
	<?php if (isset($_SESSION['admin'])): ?>
		<a class="nav-link" href="logout.php">[logout]</a>
	<?php endif; ?>
	<?php if (!(isset($_SESSION['admin']))): ?>
		<a class="nav-link" href="signup.php">Sign up</a>
	<?php endif; ?>

    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
</header>

<div class="jumbotron">
  <h1 class="display-3">Hi Car Lovers!</h1>
  <p class="lead">Our inventory consists of all, Sports, Classic, Supercars and many more.</p>
  <hr class="my-4">
  <p>World class rides available.</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="rides.php" role="button">Checkout Our Rides!</a>
  </p>
</div>

<!-- Footer -->
<footer class="page-footer font-small special-color-dark pt-4">

    <div class="footer-copyright text-center py-3">© 2018 Copyright:
      <a href="index.php"> Faltu.com</a>
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->
</body>
</html>


