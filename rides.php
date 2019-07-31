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
			margin-top: 20px;
			list-style-type: none;
		}

		p{
			padding-left: 30px;
		}

		#pagination
		{
			text-align: center;
		}

		header>h1
		{
			padding-left: 1100px;
		}

		#sele
		{
			margin-left: 10px;
		}
		.list-group-item
		{
			width: 200px;
		}
		#cat
		{
			margin-left: 20px;
		}

	</style>
</head>
<body>

<header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Faltu Rentals</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="rides.php">Rides <span class="sr-only">(current)</span></a>
      </li>
	<?php if (isset($_SESSION['admin'])): ?>
		<?php if ($admin == 1): ?>	
		<li class="nav-item">
		<a class="nav-link" href="create.php">Manage</a>
		</li>
		<?php endif; ?>
	<?php endif; ?>

      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
    </ul>
    	<?php if (!isset($_SESSION['admin'])): ?>
		<a class="nav-link" href="login.php">Sign In</a>
	<?php endif; ?>
	<?php if (isset($_SESSION['admin'])): ?>
		<a class="nav-link" href="logout.php">Sign Out</a>
	<?php endif; ?>
	<?php if (!(isset($_SESSION['admin']))): ?>
		<a class="nav-link" href="signup.php">Sign up</a>
	<?php endif; ?>

    <form class="form-inline my-2 my-lg-0" action="searchRides.php" method="POST">
      <input class="form-control mr-sm-2" type="text" name="searchResult" placeholder="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
	<select name="category" class="form-control" id="sele">
		<option value="vehicle" selected="selected">Vehicle Name</option>
		<option value="make">Make</option>
	</select>
    </form>
  </div>
</nav>
</header>
<hr class="my-4">

<?php

if(isset($_GET['success']))
{
	$answer = $_GET['success'];

	if($answer == "yes"){
	?>
	<div class="alert alert-success">
  		<strong>Welcome <?= $_SESSION['username'] ?> </strong>!
	</div>
	
<?php 
}


}

?>

<div>
<?php if (isset($_SESSION['admin'])): ?>
<p><a href="rides.php?sortby=carname">Sort By Car Name</a></p>
<?php endif; ?>
</div>
<div id="cat">
	<h3>Categories</h3>
	<ul class="list-group">
	<li class="list-group-item"><a href="filterRides.php?s=Toyota">Toyota</a></li>
	<li class="list-group-item"><a href="filterRides.php?s=Acura">Acura</a></li>
	<li class="list-group-item"><a href="filterRides.php?s=BMW">BMW</a></li>
	<li class="list-group-item"><a href="filterRides.php?s=Honsda">Honda</a></li>
	<li class="list-group-item"><a href="filterRides.php?rented=1">Rented</a></li>
	</ul>
</div>
<section>
	<ul id="ul">

	<div id="pagination">
	  	<p><?php echo $textline2; ?></p>
	  	<div id="pagination_controls"><?php echo $paginationCtrls; ?></div>
  	</div>


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
<hr class="my-4">
	<p><?php if($imageName == null): ?>
	<img src="images\noimage.JPG" >
	<?php else:?>
	<img src="images\<?=$imageName?>">
	<?php endif; ?>
	
	<p><b>Vehicle Name :</b> <?=$Make?> <?=$VehicleName?></p>
	<p><b>Year :</b> <?=$Year?> </p>
	<p><b>Rental Amount Per-Week :</b> $<?=$Amount?></p>
	</p>

	<?php if($rented == 1): ?>
	<div class="alert alert-dismissible alert-danger">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Oh snap!</strong> This vehicle is currently unavailable.
	</div>
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
				<hr class="my-4">
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
