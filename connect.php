<?php


$database_host = "us-cdbr-iron-east-01.cleardb.net";
$database_username = "b8af646233baf0";
$database_password = "0c773647";
$database_name = "heroku_8b395f676480b4c";


$conn = mysqli_connect($database_host, $database_username, $database_password) or die("unable to connect to database.");
mysqli_select_db($conn, $database_name) or die ("Unable to select");
