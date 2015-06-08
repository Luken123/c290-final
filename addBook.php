<?php
ini_set('display_errors', 'On');
session_start();

$mysqli = new mysqli("oniddb.cws.oregonstate.edu","luken-db", "rHL5UMGvjDYSkTYk","luken-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error" .$mysqli->connect_errno . "luken-db" . $mysqli->connect_error;
}
else{
	
}

//create variables
$username = $_SESSION["username"];
$title = $_GET["title"];
$author = $_GET["author"];
$summary = $_GET["summary"];
$rating = $_GET["rating"] + 0;


//input validation for adding a movie
if ($_GET['title'] == "") {
	echo 'Title is a required field.<br>';
	echo '<a href="roo.php"> Return </a>';
	exit;
}



//prepared statement from lecture and php manual

if (!($stmt = $mysqli->prepare("INSERT INTO bookshelf (id, title, author, summary, user, rating) VALUES (null,?,?,?,?,?);"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
		if (!$stmt->bind_param("ssssi", $title, $author, $summary, $username, $rating)) {
		   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		   
		    if ($mysqli->errno == 1062) {
		    	echo "Duplicate entry. Try again<br>";
		    	echo '<a href="roo.php"> Return </a>';
		    	exit;
		    }
		   
		}
 			
$stmt->close();

header('Location: http://web.engr.oregonstate.edu/~luken/roo.php');
?>