<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include "../../connect.php";

header('Content-Type: application/json');

if (isset($_GET["class_id"])) {
    $class_id = $_GET["class_id"];
    $query = mysqli_query($conn, 'SELECT * FROM classes where class_id = '.$class_id);

    $class_data = array();

    while ($class = mysqli_fetch_assoc($query)) {
        $class_data[] = array('class' => $class);
    }

    $output = json_encode(array('class' => $class_data), JSON_PRETTY_PRINT);

} else {
    $output = "{}";
}

echo $output;


