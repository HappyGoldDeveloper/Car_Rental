<?php

require 'session.php';

$admin = "";

if(isset($_SESSION['admin']))
{
	$admin = $_SESSION['admin'];
}


if ((empty($_POST['searchResult']))) 
{
	header("location:rides.php");
}

$userID = "";
if(isset($_SESSION['userId']))
{
	$userID = $_SESSION['userId'];
}

$searchResult = "";
if (isset($_POST['searchResult']))
{
	$searchResult = $_POST['searchResult'];
}

$query = " ";
							/*
							pagination code here
							*/
							$sql_for_pagination = "";
							$selection = $_POST['category'];
							$sql_for_pagination = "SELECT COUNT(*) FROM Cars WHERE Make LIKE '$searchResult%'";
							$Page_rows = $db->prepare($sql_for_pagination); 
							$Page_rows->execute();
							$row_Count = $Page_rows->rowCount();
							$row_Count = $Page_rows->fetch();
							$rowsss = $row_Count[0];
							$page_rows = 10;
							$last = ceil($rowsss/$page_rows);

							if ($last< 1) 
							{
								$last = 1;
							}

							$pagenum = 1;

							if(isset($_GET['pn']))
							{
								$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
							}

							if ($pagenum < 1)
							{ 
							    $pagenum = 1; 
							} 
							else if ($pagenum > $last) 
							{ 
							    $pagenum = $last; 
							}

							$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;


							$textline1 = "Testimonials (<b>$rowsss</b>)";
							$textline2 = "Page <b>$pagenum</b> of <b>$last</b>";

							$paginationCtrls = '';
							// If there is more than 1 page worth of results
							if($last != 1)
							{
								/* First we check if we are on page one. If we are then we don't need a link to 
								   the previous page or the first page so we do nothing. If we aren't then we
								   generate links to the first page, and to the previous page. */
								if ($pagenum > 1) 
								{
							        $previous = $pagenum - 1;
									$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp; &nbsp; ';
									// Render clickable number links that should appear on the left of the target page number
									for($i = $pagenum-4; $i < $pagenum; $i++)
									{
										if($i > 0)
										{
									        $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
										}
								    }
							    }

							    $paginationCtrls .= ''.$pagenum.' &nbsp; ';

							    for($i = $pagenum+1; $i <= $last; $i++)
							    {
									$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
									if($i >= $pagenum+4)
									{
										break;
									}
								}

								if ($pagenum != $last) 
								{
							        $next = $pagenum + 1;
							        $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a> ';
							    }
							}
							$list = '';

$selection = $_POST['category'];

if ($selection == 'make') 
{
	$query = "SELECT * FROM Cars WHERE Make LIKE '$searchResult%' ORDER BY Make ASC $limit";
}
elseif ($selection == 'vehicle') 
{
	$query = "SELECT * FROM Cars WHERE VehicleName LIKE '$searchResult%' ORDER BY VehicleName ASC $limit";
}

$statement = $db->prepare($query); 
// Returns a PDOStatement object.
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
				<a href="filterRides.php?s=Toyota">Toyota</a>
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

<form action="searchRides.php" method="POST">
<div>
	<label>Search:</label>
	<input type="text" name="searchResult" placeholder="Seach">
	<input type="submit" name="submit">
	<select name="category">
		<option value="vehicle" selected="selected">Vehicle Name</option>
		<option value="make">Make</option>
	</select>
</div>
	<div id="pagination">
	  	<p><?php echo $textline2; ?></p>
	  	<div id="pagination_controls"><?php echo $paginationCtrls; ?></div>
  	</div>
</form>

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
		<p><span><?=$Year?> </span></p>
		<p>
		<?=$Make?>
		</p>
		<p>$
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

		<?php if ($admin == 1): ?>
		<?php if($imageName != null): ?>
		<p>
			<a href="deleteImage.php?id=<?=$id?>">Delete this image</a>
		</p>
		<?php endif; ?>
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
	<?php else: ?>
		<h1>No Results not Found</h1>
	<?php endif; ?>
	
	</ul>
</section>
<footer>
	
</footer>
</body>
</html>
