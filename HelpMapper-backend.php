<?php
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
