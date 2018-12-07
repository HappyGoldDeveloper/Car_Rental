<?php

require 'session.php';

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

$query = "";
$car = "";

if(isset($_GET['s']))
{
	$car = $_GET['s'];
	$query = "SELECT * FROM Cars WHERE Make = '$car'";
}

if(isset($_GET['rented']))
{
	$rented = $_GET['rented'];
	$query = "SELECT * FROM Cars WHERE rented = '$rented'";
}

$statement = $db->prepare($query); 
$statement->execute();
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<title>F.A.L.T.U Rentals</title>
	<style type="text/css">
		#ul li
		{
			border-style: solid;
			border-radius: 20px;
			margin-top: 20px;
			list-style-type: none;
		}

		p{
			padding-left: 30px;
		}
	</style>
</head>
<body>
<header>
	<img src="images/logo.jpg">
</header>
<h1><?=$car?></h1>

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
	<p><a href="signup.php">Sign up</a></p>
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
<?php if (isset($_SESSION['admin'])): ?>
<p><a href="rides.php?sortby=carname">Sort By Car Name</a></p>
<?php endif; ?>
</div>
<div>
	<nav>
		<ul>
			<li>
				<a href="rides.php?showOnly=Toyota">Toyota</a>
			</li>
				<li>
				<a href="filterRides.php?s=Acura">Acura</a>
			</li>
			<li>
				<a href="filterRides.php?s=BMW">BMW</a>
			</li>
			<li>
				<a href="filterRides.php?s=Honda">Honda</a>
			</li>
		</ul>
	</nav>
</div>
<section>
	<ul id="ul">

	<?php $records =0; ?>
	<?php if ($statement->rowCount() != 0):?>

		<?php while ($row = $statement->fetch()): ?>

			<?php $_SESSION['row'] = $row; ?>
			<?php $id = $row['VehicleId']; ?>
			<?php $VehicleName = $row['VehicleName']; ?>
			<?php $Year = $row['Year']; ?>
			<?php $Amount = $row['Amount']; ?>
			<?php $Make = $row['Make']; ?>
			<?php $imageName = $row['imageName']; ?>

		<li>
		<p>
		<h3><?=$VehicleName?></h3>
		</p>
		<p><span><?php echo $Year; ?> </span></p>
		<p>
		<?=$Make?>
		</p>
		<p>
		<?=$Amount?>
		</p>

		<?php if($imageName == null): ?>
		<img src="images\noimage.JPG">
		<?php else:?>
		<img src="images\<?=$imageName?>">
		<?php endif; ?>

		<?php if ($admin == 1): ?>
		<p>
		<a href="edit.php?id=<?=$id?>">Edit this vehicle entry</a>
		</p>
		<?php endif; ?>


		<?php if (isset($_SESSION['admin'])): ?>
		<button><a href="addsuggestion.php?id=<?=$id?>">Add a suggestion</a></button>
		<?php endif; ?>
		<?php if (isset($_SESSION['admin'])): ?>
		<button><a href="rides.php?sortby=date">Sort by Date</a></button>
		<button><a href="rides.php?sortby=title">Sort by Title</a></button>
		<?php endif; ?>

		<?php if (isset($_SESSION['admin'])): ?>
		<?php  
		 $sql = "SELECT * FROM Suggestion WHERE VehicleId = $id";
		 if (isset($_GET['sortby'])) 
			{
				if ($_GET['sortby'] == 'date') 
				{
					$sql = $sql . " ORDER BY Date";
				}
			}
			 if (isset($_GET['sortby'])) 
			{
				if ($_GET['sortby'] == 'title') 
				{
					$sql = $sql . " ORDER BY Title";
				}
			}
         $stuff = $db->prepare($sql);
         $stuff->execute();
		 while($row_suggestion = $stuff->fetch()): ?>
		 	<?php $ID = $row_suggestion['SuggestionId']; ?>
		 	<?php if ($row_suggestion['VehicleId'] == $id): ?>
		 		<h4><?=$row_suggestion['Title']?></h4>
		 		<p><?= $row_suggestion['Comment'] ?></p>
		 		<p><?=$row_suggestion['Date']?></p>
		 		<?php if (($row_suggestion['UserId'] == $userID) || ($admin == 1)): ?>

		 			<p><a href="editComment.php?id=<?=$ID?>">Edit comment</a></p>
		 		<?php endif; ?>

		 		
		 	<?php endif; ?>

		 <?php endwhile ?>
		<?php endif;?>
		</li>

		<?php endwhile ?>
	<?php endif; ?>
	</ul>
</section>
<footer>
	
</footer>
</body>
</html>
