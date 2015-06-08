<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
//Include Connection Info.
//Connect to the Database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "luken-db", "rHL5UMGvjDYSkTYk", "luken-db");
    
    if(!$mysqli || $mysqli->connect_errno) {
        echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }

$stmt = $mysqli->prepare("SELECT username FROM bookshelfUsers");
$stmt->execute();
$stmt->bind_result($results);
$prohibited_user_names = array();
while ( $stmt->fetch() ){
	$prohibited_user_names[] = $results;
}
$stmt->close();
//Convert User_Name Array to a JSON object.
echo json_encode($prohibited_user_names);
//Close Connection to Database
$mysqli->close();
?>