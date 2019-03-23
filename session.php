<?php
   require 'connect.php';
   global $db;
   session_start();

   

   if (isset($_SESSION['userId']))
   {
      $session_userId = $_SESSION['userId'];

      $query = "SELECT * FROM Users WHERE userId = '$session_userId'";
      $statement =$db->prepare($query);
      $statement->execute();
      $row = $statement->fetch();

      $_SESSION['admin'] = $row['admin'];
      $_SESSION['USERID'] = $row['userId'];
      $_SESSION['username'] =$row['username'];
   }
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>