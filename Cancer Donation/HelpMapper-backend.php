<?php

include('db/db.php');


$location = mysqli_query($con,"SELECT * FROM `salons`");
while($current = mysqli_fetch_assoc($location)){
$locations[] =$current;
}

echo json_encode( $locations ); // displays the data 
//json is like converter between php and JS 
?>