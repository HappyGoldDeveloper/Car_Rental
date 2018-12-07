<?php

require 'session.php';
global $db;

if (isset($_POST['vehiclename']) and isset($_POST['make']) and isset($_POST['year']) and isset($_POST['rentalamount']))
{
	$vehiclename = filter_input(INPUT_POST,'vehiclename',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$make = filter_input(INPUT_POST,'make',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$year = filter_input(INPUT_POST,'year',FILTER_VALIDATE_INT);
	$rentalAmount = filter_input(INPUT_POST,'rentalamount',FILTER_VALIDATE_INT);
	$image = $_POST['image'];

	 $id = $_GET['id'];

	if (isset($_POST['update'])) 
	{
	
		$vehiclenameQuery = "UPDATE Cars SET VehicleName = :vehiclename WHERE VehicleId='$id'";
		$statementTitle = $db->prepare($vehiclenameQuery);
		$statementTitle->bindValue(':vehiclename',$vehiclename);
		$statementTitle->execute();

		$yearQuery = "UPDATE Cars SET Year = :year WHERE VehicleId='$id'";
		$statement = $db->prepare($yearQuery);
		$statement->bindValue(':year',$year);
		$statement->execute();

		$amountQuery ="UPDATE Cars SET Amount = :rentalAmount WHERE VehicleId ='$id'";
		$statementDate =$db->prepare($amountQuery);
		$statementDate->bindValue(':rentalAmount',$rentalAmount);
		$statementDate->execute();

		$makeQuery = "UPDATE Cars SET Make = :make WHERE VehicleId='$id'";
		$statementMake = $db->prepare($makeQuery);
		$statementMake->bindValue(':make',$make);
		$statementMake->execute();


		header("Location:rides.php");
	}

	if (isset($_POST['delete']))
	{
		$deleteQuery = "DELETE FROM Cars WHERE VehicleId = :id";
		$deleteStatement = $db->prepare($deleteQuery);
		$deleteStatement->bindValue(':id',$id);
		$deleteStatement->execute();
		header("Location:rides.php");

	}
}


?>
