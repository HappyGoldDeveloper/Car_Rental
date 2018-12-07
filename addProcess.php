<?php

require 'session.php';


if (isset($_GET['id'])) 
{
	$id=$_GET['id'];
}

if (isset($_GET['name'])) 
{
	$imageName = $_GET['name'];
}

$imageQuery = "UPDATE Cars SET imageName = :image WHERE VehicleId='$id'";
$statement = $db->prepare($imageQuery);
$statement->bindValue(':image',$imageName);
$statement->execute();

header("location:rides.php");

?>