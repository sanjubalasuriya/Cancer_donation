<?php
<<<<<<< HEAD
require_once __DIR__ . '/db/db.php';

header('Content-Type: application/json; charset=utf-8');

$locations = [];
$res = mysqli_query($con, 'SELECT `id`, `s_id`, `name`, `address`, `lat`, `lng`, `contact` FROM `salons` ORDER BY `id` ASC');
if ($res) {
    while ($current = mysqli_fetch_assoc($res)) {
        $locations[] = $current;
    }
}

echo json_encode($locations, JSON_UNESCAPED_UNICODE);
=======

include('db/db.php');


$location = mysqli_query($con,"SELECT * FROM `salons`");
while($current = mysqli_fetch_assoc($location)){
$locations[] =$current;
}

echo json_encode( $locations ); // displays the data 
//json is like converter between php and JS 
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
