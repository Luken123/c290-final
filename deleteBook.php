<?php
ini_set('display_errors', 'On');


$mysqli = new mysqli("oniddb.cws.oregonstate.edu","luken-db", "rHL5UMGvjDYSkTYk","luken-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error" .$mysqli->connect_errno . "luken-db" . $mysqli->connect_error;
}
else{
	
}

//code from lecture
//deletes movie from database
$book_id = $_POST['book_id'];
		if (!($stmt = $mysqli->prepare("DELETE FROM bookshelf WHERE id = ?"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
		if (!$stmt->bind_param("i", $book_id)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
		header('Location: http://web.engr.oregonstate.edu/~luken/roo.php');
$stmt->close();

?>