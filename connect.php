<?php


$database_host = "us-cdbr-iron-east-01.cleardb.net";
$database_username = "b868297364dd46";
$database_password = "08f3a3d5";
$database_name = "heroku_20efd45a2eed6a8";


$conn = mysqli_connect($database_host, $database_username, $database_password) or die("unable to connect to database.");
mysqli_select_db($conn, $database_name) or die ("Unable to select");
