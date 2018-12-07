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