<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); //create new session or resume existing session
$errorCount = 0;
//if registration form has been sent, check data and bounce to login page -- otherwise, display registration form 
if(!empty($_POST)) {
    if ($_POST["username"]) {
        $username = htmlspecialchars($_POST["username"]);
    }
    else {
        echo "No username entered.";
        $errorCount++;
    }
    if ($_POST["password"]) {
        $password = htmlspecialchars($_POST["password"]);
    }
    else {
        echo "No password entered.";
        $errorCount++;
    }
    if ($_POST["email"]) {
        $email = htmlspecialchars($_POST["email"]);
    }
    else {
        echo "No email address entered.";
        $errorCount++;
    }
    //if we encountered an error above, exit
    if($errorCount > 0) {
        exit();
    } 
    //open a session with the database
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "luken-db", "rHL5UMGvjDYSkTYk", "luken-db");
    
    if(!$mysqli || $mysqli->connect_errno) {
        echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    //$query = "SELECT username FROM bookshelfUsers WHERE 1";
    
    //$query = "SELECT count(*) FROM bookshelfUsers WHERE username = '" . $username . "' LIMIT 1";
    //adapted from stackoverflow
    $query = "SELECT * FROM bookshelfUsers WHERE username='" . $username . "'";
    $result = $mysqli->query($query);
    //$result = mysql_query($query);
    if(mysqli_num_rows($result) > 0) {
    //if username is found
         //echo "<script type='text/javascript'>alert('This username has already been taken!')</script>";
       header('Location: http://web.engr.oregonstate.edu/~luken/finalLog.html');
        exit();
    }
    //if($result = $mysqli->query($query)) {
//!!this part doesn't work properly
    //    if($result == $_POST['username']) {
    //        echo "This username is already taken.");
    //        $errorCount++;
    //    }
    //}
    //if no errors and the user has not registered before, add the user to the database
    //prepare the statement
    if (!($stmt = $mysqli->prepare("INSERT INTO bookshelfUsers(username, pass, email) VALUES (?, ?, ?)"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    //bind and execute
    if (!$stmt->bind_param("ssi", $username, $password, $email)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    //close connection

    $stmt -> close();
    $mysqli -> close();
    //bounce user to login page after registration

    header('Location: http://web.engr.oregonstate.edu/~luken/finalLog.php');

    exit();
    }      
?> 
