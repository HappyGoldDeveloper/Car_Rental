<?php

require 'session.php';


use phpmailer\PHPMailer\PHPMailer;
use phpmailer\PHPMailer\Exception;
use phpmailer\PHPMailer\POP3;
use phpmailer\PHPMailer\OAuth;
use phpmailer\PHPMailer\SMTP;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/OAuth.php';
require 'phpmailer/src/POP3.php';

if (isset($_SESSION['USERID'])) 
{
	$userID = $_SESSION['USERID'];
}

	if (isset($_POST['verify'])) 
	{


		$fname = $_POST['fname'];
		$lname =$_POST['lname'];
		$dl = $_POST['dl'];
		$email = $_POST['email'];
		$ccnumber = $_POST['ccnumber'];

		$query_for_make = "SELECT VehicleId,VehicleName,Make FROM Cars";
		$statement_make = $db->prepare($query_for_make);
		$statement_make->execute();

		$selected_id = "";

		$get_id = "";

		if (isset($_POST['verify'])) 
		{
			if (isset($_POST['car'])) 
			{
				$get_id = $_POST['car'];
			}
		}

		$image_query = "SELECT VehicleName,Make,imageName FROM Cars WHERE VehicleId = '$get_id'";
		$statement_image = $db->prepare($image_query);
		$statement_image->execute();

		$nameAndMake_query = "SELECT VehicleName,Make,Year FROM Cars WHERE VehicleId = '$get_id'";
		$statement_nameAndMake = $db->prepare($nameAndMake_query);
		$statement_nameAndMake->execute();
		$result = $statement_nameAndMake->fetch();
		$carname = $result['VehicleName']; 
		$carmake = $result['Make'];
		$year = $result['Year'];
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
			<a href="rides.php">Rides</a>
			<h1><?=$get_id?></h1>
		</header>
	</body>
		<form action="rentPro.php" method="POST">
			<ul>
				<li>
					<label>First Name:</label>
					<input type="text" name="fname" value="<?=$fname?>">
				</li>
				<li>
					<label>Last Name:</label>
					<input type="text" name="lname" value="<?=$lname?>">
				</li>
				<li>
					<label>Driving License No:</label>
					<input type="text" name="dl" value="<?=$dl?>">
				</li>
				<li>
					<label>Email Address:</label>
					<input type="email" name="email" value="<?=$email?>">
				</li>
				<li>
					<label>Credit Card No:</label>
					<input type="number" name="ccnumber" value="<?=$ccnumber?>">
				</li>
				<li>
					<input type="hidden" name="carID" value="<?=$get_id?>">
					<input type="hidden" name="carname" value="<?=$carname?>">
					<input type="hidden" name="carmake" value="<?=$carmake?>">
					<input type="hidden" name="year" value="<?=$year?>">
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
					<input type="submit" name="rent" value="Rent"> 
					<input type="submit" name="cancel" value="cancel">
				</li>
			</ul>
		</form>
		<div>
	 		 <?php if ($statement_image->rowCount() != 0):?>
						<?php while ($image_row =$statement_image->fetch()): ?>

							<?php $image = $image_row['imageName']; ?>
							<?php $carname = $image_row['VehicleName']; ?>
							<?php $carmake = $image_row['Make']; ?>

							<?php if ($image != null): ?>
								<img src="images/<?=$image?>">
							<?php else: ?>
								<img src="images/noimage.jpg">
							<?php endif; ?>
						<?php endwhile; ?>
			<?php endif; ?> 
		</div>
	</html>



	<?php

		}
		elseif (isset($_POST['rent'])) 
		{
				if ((empty($_POST['fname'])) || (empty($_POST['lname'])) || (empty($_POST['dl'])) || (empty($_POST['email'])) || (empty($_POST['ccnumber']))) 
				{
					?>
					<script type="text/javascript">
						alert("Empty Fields!");
					</script>
					<?php
					header("location:rides.php");
				}
				else
				{
					$firstName = $_POST['fname'];
					$lastName =$_POST['lname'];
					$drivingLicense = $_POST['dl'];
					$emailAddress = $_POST['email'];
					$creditCardNumber = $_POST['ccnumber'];
					//$userID
					$get_id = $_POST['carID'];

					$carname = $_POST['carname'];
					$carmake =$_POST['carmake'];
					$year = $_POST['year'];

					$sql = "INSERT INTO Rent (RentID,userId,VehicleId,VehicleName,Make,firstName,lastName,dl,email,ccnumber) values ('',:userid,:vehicleid,:vehiclename,:make,:firstname,:lastname,:dl,:email,:ccnumber)";
					$adding = $db->prepare($sql);
					$adding->bindValue(':userid',$userID);
					$adding->bindValue(':vehicleid',$get_id);
					$adding->bindValue(':vehiclename',$carname);
					$adding->bindValue(':make',$carmake);
					$adding->bindValue(':firstname',$firstName);
					$adding->bindValue(':lastname',$lastName);
					$adding->bindValue(':dl',$drivingLicense);
					$adding->bindValue(':email',$emailAddress);
					$adding->bindValue(':ccnumber',$creditCardNumber);
					$adding->execute();

					$value = 1;

					$update_query = "UPDATE Cars SET rented = :value WHERE VehicleId ='$get_id'";
					$statement = $db->prepare($update_query);
					$statement->bindValue(':value',$value);
					$statement->execute();


					$newCC = substr($creditCardNumber, -4);

					$mail = new PHPMailer(true);
					$mail->SMTPOptions = array('ssl' => array('verify_peer'=>false,'verify_peer_name'=>false,'allow_self_signed'=>true));
					$mail->isSMTP();
					$mail->Host = 'smtp.gmail.com';
					$mail->SMTPAuth = true;

					$body = ". Hi {$firstName}! .\n " .
							"\r\n .Guess What!? Your Car Rental Begins from Today ! . \r\n" .
							"\r\n .The Details are as follows . \n" .
							"\r\n .Vehicle: {$carname}.\n" .
							"\r\n . Make:  {$carmake} . \r\n".
							"\r\n .Year:  {$year} . \r\n" .
							"\r\n .Personal Information : . \r\n" .
							"\r\n .Driving License No:  {$drivingLicense} . \r\n".
							"\r\n .Credit Card Number: ***** {$newCC} . \r\n" .
							"Enjoy your ride!";
					
					// $mail->isHTML();
					$mail->Username = 'noreply.faltu@gmail.com';
					$mail->Password = 'Malaysia01!!';
					$mail->SMTPSecure = 'tls';
					$mail->Port = 587;

					$mail->From = 'noreply@faltu.com' ;
					$mail->FromName = 'F.A.L.T.U Car Rentals';

					$mail->AddAddress($emailAddress);
					$mail->isHTML(true);
					$mail->Subject = 'Rental Confirmation';
					$mail->Body= $body;
					$mail->Send();

					header('location:rides.php');
				}
		}
		elseif(isset($_POST['cancel']))
		{
			header("location:rides.php");
		}
?>
		