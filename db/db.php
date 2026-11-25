<?php
/**
 * Shared MySQLi database connection.
 */

$appConfig = require __DIR__ . '/../config/app.php';
$dbConfig = $appConfig['db'];

mysqli_report(MYSQLI_REPORT_OFF);

$con = @mysqli_connect(
    $dbConfig['host'],
    $dbConfig['username'],
    $dbConfig['password'],
    $dbConfig['name']
);

if (!$con) {
    error_log('Database connection failed: ' . mysqli_connect_error());
    http_response_code(500);
    die('Service temporarily unavailable. Please try again later.');
}

mysqli_set_charset($con, $dbConfig['charset']);
