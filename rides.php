<?php

require 'session.php';

$admin = 2;



if(isset($_SESSION['admin']))
{
	$admin = $_SESSION['admin'];
}


$userID = "";
if(isset($_SESSION['userId']))
{
	$userID = $_SESSION['userId'];
}

$username ="";
if (isset($_SESSION['username'])) 
{
	$username = $_SESSION['username'];
}

$empty = "";
if (empty($_POST['searchResult'])) 
{
	$empty = "Empty fields!";
}
							/*
							pagination code here
							*/
							$sql_for_pagination = "SELECT COUNT(*) FROM Cars";
							$Page_rows = $db->prepare($sql_for_pagination); 
							$Page_rows->execute();
							$row_Count = $Page_rows->rowCount();
							$row_Count = $Page_rows->fetch();
							//rowssss is the number of rows
							$rowsss = $row_Count[0];

							//items_on_page
							$page_rows = 5;
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

							$sql_2 = "SELECT * FROM Cars ORDER BY VehicleId DESC $limit";

							$textline1 = "Testimonials (<b>$rowsss</b>)";
							$textline2 = "Page <b>$pagenum</b> of <b>$last</b>";

							$paginationCtrls = '';
							if($last != 1)
							{
								if ($pagenum > 1) 
								{
							        $previous = $pagenum - 1;
									$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp; &nbsp; ';
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


$query = "SELECT * FROM Cars ORDER BY VehicleName ASC $limit";
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

		#pagination
		{
			margin-left: 650px;
		}

		header>h1
		{
			padding-left: 1100px;
		}

	</style>
</head>
<body>

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
				<a href="filterRides.php?s=Honsda">Honda</a>
			</li>
			<li>
				<a href="filterRides.php?rented=1">Rented</a>
			</li>
		</ul>
	</nav>
</div>
<section>
	<ul id="ul">

<form action="searchRides.php" method="POST">
<div>
	<label>Search:</label>
	<input type="text" name="searchResult" placeholder="Search">
	<h5><?=$empty?></h5>
	<input type="submit" name="submit">
	
	<select name="category">
		<option value="vehicle" selected="selected">Vehicle Name</option>
		<option value="make">Make</option>
	</select>
  	<!-- <input type="radio" name="category" value="vehicle" name="vehicle_radio" checked="checked"> 
	Vehicle Name

	<input type="radio" name="category" value="make" name="make_radio" > Make -->

</div>
	<div id="pagination">
	  	<p><?php echo $textline2; ?></p>
	  	<div id="pagination_controls"><?php echo $paginationCtrls; ?></div>
  	</div>
</form>

	<?php $records = 0; ?>
	<?php if ($statement->rowCount() != 0):?>

		<?php while ($row = $statement->fetch()): ?>

			<?php $_SESSION['row'] = $row; ?>
			<?php $id = $row['VehicleId']; ?>
			<?php $VehicleName = $row['VehicleName']; ?>
			<?php $Year = $row['Year']; ?>
			<?php $Amount = $row['Amount']; ?>
			<?php $Make = $row['Make']; ?>
			<?php $imageName = $row['imageName']; ?>
			<?php $rented = $row['rented']; ?>

<li>
				<p>
				<h3>Name :<?=$VehicleName?></h3>
				</p>
				<p><span>Year :<?=$Year?> </span></p>
				<p>
					Make :<?=$Make?>
				</p>
				<p>
					Rental Amount Per-Week : $<?=$Amount?>
				</p>

				<?php if($imageName == null): ?>
				<img src="images\noimage.JPG"><br>
				<?php else:?>
				<img src="images\<?=$imageName?>"><br>
				<?php endif; ?>

				<?php if($rented == 1): ?>
				<img id="rented" src="images\rented.jpg">
				<?php endif; ?>

				<?php if($rented != 1): ?>
				<?php if ($admin == 1 || $admin == 0): ?>
				<a href="rent.php?id=<?=$id?>">Rent Vehicle</a><br><br>
				<?php endif; ?>
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
				<?php elseif ($imageName == null): ?>
				<p>
					<button><a href="add.php?id=<?=$id?>">Add Image</a></button>
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
	
	<div id="pagination">
	  	<p><?php echo $textline2; ?></p>
	  	<div id="pagination_controls"><?php echo $paginationCtrls; ?></div>
  	</div>
<footer>
	
</footer>
</body>
</html>
