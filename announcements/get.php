<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include "../connect.php";

header('Content-Type: application/json');

$query = mysqli_query($conn, 'SELECT * FROM announcements');

$announcements_list = array();

while ($announcement = mysqli_fetch_assoc($query)) {
    $announcements_list[] = array('announcement' => $announcement);
}

$output = json_encode(array('announcements' => $announcements_list));

echo $output;


