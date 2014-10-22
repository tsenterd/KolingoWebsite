<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include "../../connect.php";

header('Content-Type: application/json');

$query = mysqli_query($conn, 'SELECT * FROM homework');

$homework_list = array();

while ($homework = mysqli_fetch_assoc($query)) {
    $homework_list[] = array('homework' => $homework);
}

$output = json_encode(array('homework_list' => $homework_list), JSON_PRETTY_PRINT);

echo $output;


