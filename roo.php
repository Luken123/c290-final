<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
//check to be sure username has been set via login page
if(isset($_SESSION["username"])) {
	$_SESSION["active"] = "yes"; //set the session variable to yes, because we're in an active session
	$username = htmlspecialchars($_SESSION["username"]);
}
//adapted from example code in sessions lecture
//if not in an active session, send them back to the login page
if(!isset($_SESSION["active"])) { 
	$filePath = explode('/', $_SERVER['PHP_SELF'], -1);
	$filePath = implode('/', $filePath);
	$redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
	header("Location: {$redirect}/loginz.php", true);
	exit();
}

echo  "Logged in as " . $username . ".";

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<title>List of Book</title>
</head>
<body>
 <span class="pull-right"><a href="http://web.engr.oregonstate.edu/~luken/finalLog.php?action=end">Logout</a></span>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Add a New Book Review</h3>
		</div>
		<div class="panel-body">
			<form action ="http://web.engr.oregonstate.edu/~luken/addBook.php" method="GET" class="form-horizontal" role="form">
				<div class="form-group">
					<label for="title" class="col-sm-2 control-label">Title</label>
					
					<div class="col-sm-10">
						<input type="text" required name="title" class="form-control" id="title" placeholder="Enter Title Here">
					</div>
				</div>
				<div class="form-group">
					<label for="author" class="col-sm-2 control-label">Title</label>
					<div class="col-sm-10">
						<input type="text" required name="author" class="form-control" id="author" placeholder="Enter Author Here">

					</div>
					</div>
						<div class="form-group">
    <label for="summary" class="col-sm-2 control-label">Book Review</label>
    <div class="col-sm-10">
 <textarea required name="summary" cols="" rows="" class="form-control"></textarea>
    </div>
  </div>
  <div class="form-group">
					<label for="rating" class="col-sm-2 control-label">Rating(1-10)</label>
					
					<div class="col-sm-10">
						<input type="number" required name="rating" min="0" max"10" class="form-control" id="title" placeholder="Enter Rating Here">
					</div>
				</div>
  					
  <div class="panel-footer" style="overflow:hidden;text-align:right;">
    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" >Submit</button>
      </form>	
     

    </div>
  </div>  
</div>
</div>
</div>

	<br />
 	<br>
	<table border='3'>
	<caption> Book Reviews</caption>
	<tr>
	<th>User
	<th>Title
	<th>Author
	<th>Rating
	<th>Review
	<th>Delete

 	<?php
 	ini_set('display errors', 'On');
 	//open a session with the database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "luken-db", "rHL5UMGvjDYSkTYk", "luken-db");
	
	if(!$mysqli || $mysqli->connect_errno) {
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	$out_id = NULL;
	$out_title = NULL;
	$out_author = NULL;
	$out_summary = NULL;
	$out_user = NULL;
	$out_rating = NULL;

if (!($stmt = $mysqli->prepare("SELECT id, title, author, summary, user, rating FROM bookshelf WHERE user = '{$username}' ORDER BY title"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

	if (!$stmt->bind_result($out_id, $out_title, $out_author, $out_summary, $out_user, $out_rating)) {
		    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$out_user" . '</td>
		    	  	<td>' . "$out_title"   .  '</td>
		    	  	<td>' . "$out_author" . '</td>
		    	  	<td>' . "$out_rating"   .  '</td>
		    	  	

		    	 	<td>' . "$out_summary" . '</td>
		    	 	<form action="deleteBook.php" method="POST">
					<td>
					 <input type="hidden" name="book_id" value="' . "$out_id" . '">
					 <input type="submit" value="X">
					 
					 </td>
					 </form>
		    	 	
		    	 	</tr>';
		}
?>
</table>
</body>
</html>

<?php
$stmt->close();
?>

    