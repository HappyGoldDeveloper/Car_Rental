<?php

require 'session.php';

$imageID = "";
if (isset($_GET['id'])) 
{
	$imageID = $_GET['id'];
}

$query = "SELECT imageName FROM Cars WHERE VehicleId = '$imageID'";
$statement = $db->prepare($query); 
$statement->execute();

$records =0;
$imageName ="";
if ($statement->rowCount() != 0)
{

	while ($row = $statement->fetch())
	{
		$imageName = $row['imageName'];
	}
}

$nullName = "";

$path = "/Applications/XAMPP/xamppfiles/htdocs/practice/WebProject/images/$imageName";
unlink($path);

$updateQuery = "UPDATE Cars SET imageName = :deleteName WHERE VehicleId = '$imageID'";
$statement = $db->prepare($updateQuery);
$statement->bindValue(':deleteName',$nullName);
$statement->execute();



header("Location:rides.php");

?>
