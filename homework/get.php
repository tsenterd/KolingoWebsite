<?php

include "../connect.php";

$query = mysqli_query($conn, 'SELECT * FROM homework');

$homework_list = array();

while ($homework = mysqli_fetch_array($query, MYSQL_ASSOC)) {
    $homework_list[] = array('post' => $homework);
}

$output = json_encode(array('homework' => $homework_list));

echo $output;


