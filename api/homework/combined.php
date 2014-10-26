<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include "../../connect.php";

header('Content-Type: application/json');

$query = mysqli_query($conn, 'select * from homework order by created desc limit 5');

$combined_list = array();

while ($item = mysqli_fetch_assoc($query)) {
    $combined_list[] = array('item' => $item);
}

$output = json_encode(array('combined_list' => $combined_list), JSON_PRETTY_PRINT);

echo $output;


