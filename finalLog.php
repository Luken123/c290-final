<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); //create new session or resume existing session
$errorCount = 0;
if(isset($_GET['action']) && $_GET['action'] == 'end') { 
//if we are directed to this page with action=end as a GET
    $_SESSION = array();
    session_destroy(); //end the user's session
}
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
    //if we encountered an error above, exit
    if($errorCount > 0) {
        exit();
    } 
    //open a session with the database
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "luken-db", "rHL5UMGvjDYSkTYk", "luken-db");
    if(!$mysqli || $mysqli->connect_errno) {
        echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    //$query = "SELECT count(*) FROM bookshelfUsers WHERE username = '" . $username . "' AND pass = '" . $password . "' LIMIT 1";
    //adapted from stackoverflow
    $query = "SELECT * FROM bookshelfUsers WHERE username='" . $username . "' AND pass ='" . $password . "'";
    $result = $mysqli->query($query);
    if(mysqli_num_rows($result) > 0) {
    //if username/password combo is found
        $_SESSION["username"] = $_POST["username"];
        $mysqli -> close();
        header('Location: http://web.engr.oregonstate.edu/~luken/roo.php');
        exit();
    }
    else {
        $mysqli -> close();
        header('Location: http://web.engr.oregonstate.edu/~luken/finalLog.php');
        echo"invalid";
        exit();
    }
    //$query = mysql_query("SELECT *  FROM UserName where userName = '$_POST[user]' AND pass = '$_POST[pass]'");
    
    //$result = $mysqli->query($query);
    //if($result == //figure out how to check for username and pass here)
    //{
        //store the username in $_SESSION so we can access it to display the correct information on bookshelf.php
        //$_SESSION["username"] = $_POST["username"];
        //$mysqli -> close();
        //header('Location: http://http://web.engr.oregonstate.edu/~mcdaniad/bookshelf/bookshelf.php');
        //exit();
    //}
    //else
    //{
        //$mysqli -> close();
        //header('Location: http://http://web.engr.oregonstate.edu/~mcdaniad/bookshelf/login.php');
        //exit();
    //}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login to My Book Review</title>
</head>
<body>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="text-center">Login to My Book Review</h1>
            </div>
            <div class="modal-body">
                <form action="http://web.engr.oregonstate.edu/~luken/finalLog.php" method="POST" class="col-md-12 center-block">
                    <div class="form-group">
                        <input type="text" required name="username" class="form-control input-lg" placeholder="Username">

                    </div>
                    <div class="form-group">
                        <input type="password" required name="password" class="form-control input-lg" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-block btn-lg btn-primary" value="Login">
                        <span class="pull-right"><a href="http://web.engr.oregonstate.edu/~luken/final.html">Register</a></span>
                    </div>
                </form>
                <div class="modal-footer">
                    <div class="col-md-12">
                    </div>
                </div>

</body>
</html>