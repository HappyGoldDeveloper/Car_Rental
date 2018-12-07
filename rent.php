<?php

require 'session.php';

$query_for_make = "SELECT VehicleId,VehicleName,Make FROM Cars";
$statement_make = $db->prepare($query_for_make);
$statement_make->execute();

$selected_id = "";

$get_id = "";
if (isset($_GET['id'])) 
{
	$get_id = ($_GET['id']);
}

$query_for_image = "SELECT imageName FROM Cars WHERE VehicleId = '$get_id'";
$statement_sentover_image = $db->prepare($query_for_image);
$statement_sentover_image->execute();

if (isset($_POST['car'])) 
{
	$selected_id = $_POST['car'];
}

$image_query = "SELECT imageName FROM Cars WHERE VehicleId = '$selected_id'";
$statement_image = $db->prepare($image_query);
$statement_image->execute();


$image = "";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Rent</title>
		<style type="text/css">
		img
		{
			height: 640px;
			width: 720px;
		}
	</style>
</head>
<body>
	<header>
		<h1>Rent a Vehicle</h1>
		<h1><?=$selected_id?></h1>
		<a href="rides.php">Rides</a>
	</header>
</body>
	<form action="rentPro.php" method="POST">
		<ul>
			<li>
				<label>First Name:</label>
				<input type="text" name="fname">
			</li>
			<li>
				<label>Last Name:</label>
				<input type="text" name="lname">
			</li>
			<li>
				<label>Driving License No:</label>
				<input type="text" name="dl">
			</li>
			<li>
				<label>Email Address:</label>
				<input type="email" name="email">
			</li>
			<li>
				<label>Credit Card No:</label>
				<input type="number" name="ccnumber">
			</li>
			<li>

				<label>Vehicle</label>
				<select name="car" >
				<?php if ($statement_make->rowCount() != 0):?>
					<?php while ($rows =$statement_make->fetch()): ?>

						<?php $make = $rows['Make']; ?>
						<?php $id = $rows['VehicleId']; ?>
						<?php $name = $rows['VehicleName']; ?>

						<?php if($id == $get_id):  ?>

							<option value="<?=$id?>" selected="selected"><?=$make?> - <?=$name?></option>
						<?php else: ?>
							<option value="<?=$id?>"><?=$make?> - <?=$name?></option>
						<?php endif; ?>


					<?php endwhile;?>
				<?php endif; ?>	
				</select>

			</li>
			<li>
				<input type="submit" name="verify" value="Verify">
				<!-- <input type="submit" name="Rent" value="Rent"> -->
				<input type="submit" name="cancel" value="cancel">
			</li>
		</ul>
	</form>
	<div>
 		 <?php if ($statement_sentover_image->rowCount() != 0):?>
					<?php while ($image_row =$statement_sentover_image->fetch()): ?>

						<?php $image = $image_row['imageName']; ?>

						<?php if ($image != null): ?>
							<img src="images/<?=$image?>">
						<?php else: ?>
							<img src="images/noimage.jpg">
						<?php endif; ?>
					<?php endwhile; ?>
		<?php endif; ?> 
	</div>
</html>