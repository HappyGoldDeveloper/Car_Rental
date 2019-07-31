<?php

require 'session.php';

$errormessage = "";

if(!isset($_GET['signup']))
{
	//exit();
}
else
{
	$signupcheck = $_GET['signup'];
	$errormessage = "";

	if($signupcheck == "password"){
		
		$errormessage = "Incorrect Password.";
	}
	elseif($signupcheck == "fail"){
		
		$errormessage = "Login failed!";
	}
	elseif($signupcheck == "empty"){
		
		$errormessage = "Please enter your details!";
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
   <!--Made with love by Mutiullah Samim -->
   <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
   <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
   <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="styles.css">
	<style type="text/css">
	@import url('https://fonts.googleapis.com/css?family=Numans');

html,body{
background-size: cover;
background-repeat: no-repeat;
height: 100%;
font-family: 'Numans', sans-serif;
}

.container{
margin-top: -100px;
height: 100%;
align-content: center;
}

.card{
height: 270px;
margin-top: auto;
margin-bottom: auto;
width: 400px;
background-color: rgba(0,10,1,0.5) !important;
}

.social_icon span{
font-size: 60px;
margin-left: 10px;
color: #FFC312;
}

.social_icon span:hover{
color: white;
cursor: pointer;
}

.card-header h3{
color: white;
}

.social_icon{
position: absolute;
right: 20px;
top: -45px;
}

.input-group-prepend span{
width: 50px;
background-color: #FFC312;
color: black;
border:0 !important;
}

input:focus{
outline: 0 0 0 0  !important;
box-shadow: 0 0 0 0 !important;

}

.remember{
color: white;
}

.remember input
{
width: 20px;
height: 20px;
margin-left: 15px;
margin-right: 5px;
}

.login_btn{
color: black;
background-color: #FFC316;
width: 100px;
}

.login_btn:hover{
color: black;
background-color: #B3AFB3;
}

.links{
color: black;
}

.links a{
margin-left: 4px;
}

#message {
	display: none;
}

.error{
	color: #c4313b;
}
</style>

<script>

function valid()
{
	var validated = true;
	//alert('its here');
	var username = document.getElementById('username');
	var password = document.getElementById('password');

	//var message = document.getElementById('message');

	if(username.value === "" && password.value === "")
	{
		//alert('Please enter your username and password.');
		document.getElementById('message').innerHTML = 'Please enter your username and password.';
		document.getElementById('message').style.display = "block";
		validated = false;
	}
	else if(username.value === "" && password.value != "")
	{
		//alert('Please enter your username.');
		document.getElementById('message').innerHTML = 'Please enter your username.';
		document.getElementById('message').style.display = "block";
		validated = false;
	}
	else if(username.value != "" && password.value === "")
	{
		//alert('Please enter your password.');
		document.getElementById('message').innerHTML = 'Please enter your password.';
		document.getElementById('message').style.display = "block";
		validated = false;
	}
	else
	{
		validated = true;
	}

	return validated
}


</script>
</head>
<body>

<header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Faltu Rentals</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="rides.php">Rides <span class="sr-only">(current)</span></a>
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
		<a class="nav-link" href="logout.php">Sign Out</a>
	<?php endif; ?>
	<?php if (!(isset($_SESSION['admin']))): ?>
		<a class="nav-link" href="signup.php">Sign up</a>
	<?php endif; ?>

  </div>
</nav>
</header>
<hr class="my-4">
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Sign In</h3>
				<!-- <div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div> -->
			</div>
			<div class="card-body">
				<form action="signinprocess.php" method="POST">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" name="username" placeholder="username" id="username" required>
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" name="password" placeholder="password" id="password" required>
						<br>
						
					</div>
					<div>
						<label class="error" id="message"></label>
						<label class="error" ><?= $errormessage ?></label>
					</div>
					<!-- <div class="row align-items-center remember">
						<input type="checkbox">Remember Me
					</div> -->
					<div class="form-group">
						<button type="submit" value="Login" class="btn float-right login_btn" onclick="return valid()">Submit</button>
					</div>
				</form>
			</div>
			<?php if (!(isset($_SESSION['admin']))): ?>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					Don't have an account?<a href="signup.php">Sign Up</a>
				</div>
				<!-- <div class="d-flex justify-content-center">
					<a href="#">Forgot your password?</a>
				</div> -->
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
</body>
</html>

