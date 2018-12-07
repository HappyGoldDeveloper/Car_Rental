<?php

require 'session.php';
global $db;

if (isset($_GET['id'])) 
{
		//$title = $_GET['title'];
	$id = $_GET['id'];
	//$date = $_GET['date'];
}




if (isset($_POST['title']) and isset($_POST['text']))
{
	$title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$comment = filter_input(INPUT_POST,'text',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	

	 //$id = $_GET['id'];

	 

	if (isset($_POST['update'])) 
	{
	
		$titleQuery = "UPDATE Suggestion SET Title = :title WHERE SuggestionId='$id'";
		$statementTitle = $db->prepare($titleQuery);
		$statementTitle->bindValue(':title',$title);
		$statementTitle->execute();

		$commentQuery = "UPDATE Suggestion SET Comment = :comment WHERE SuggestionId='$id'";
		$statement = $db->prepare($commentQuery);
		$statement->bindValue(':comment',$comment);
		$statement->execute();

		header("Location:rides.php");
	}

	if (isset($_POST['delete']))
	{
		$deleteQuery = "DELETE FROM Suggestion WHERE SuggestionId = :id";
		$deleteStatement = $db->prepare($deleteQuery);
		$deleteStatement->bindValue(':id',$id);
		$deleteStatement->execute();
		header("Location:rides.php");

	}
}


?>
