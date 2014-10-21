<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include "../connect.php";

$query = mysqli_query($conn, 'SELECT * FROM homework');

$homework_list = array();

while ($homework = mysqli_fetch_assoc($query)) {
    $homework_list[] = array('post' => $homework);
}

$output = json_encode(array('homework' => $homework_list));

echo $output;


