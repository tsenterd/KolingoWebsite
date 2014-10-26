<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include "../../connect.php";

header('Content-Type: application/json');

if (isset($_GET["class_id"])) {
    $class_id = $_GET["class_id"];
    $query = mysqli_query($conn, 'SELECT * FROM announcements where class_id = '.$class_id);
    if (isset($_GET["after"])) {
        $date = urldecode($_GET["after"]);
        $query = mysqli_query($conn, 'SELECT * FROM announcements where class_id = '.$class_id.' and created > "'.$date.'"');
    }
} else {
    if (isset($_GET["after"])) {
        $date = urldecode($_GET["after"]);
        $query = mysqli_query($conn, 'SELECT * FROM announcements where created > "'.$date.'"');
    }
    $query = mysqli_query($conn, 'SELECT * FROM announcements');
}


$announcements_list = array();

while ($announcement = mysqli_fetch_assoc($query)) {
    $announcements_list[] = array('announcement' => $announcement);
}

$output = json_encode(array('announcements' => $announcements_list), JSON_PRETTY_PRINT);

echo $output;


