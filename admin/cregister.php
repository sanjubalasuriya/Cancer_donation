<?php
require_once __DIR__ . '/../helpers/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';
require_once __DIR__ . '/../helpers/id_generator.php';
require_once __DIR__ . '/../helpers/response.php';

start_secure_session();

if (empty($_SESSION['uname']) || ($_SESSION['role'] ?? '') !== 'admin') {
    json_response(false, 'Unauthorized.', [], 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method not allowed.', [], 405);
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response(false, 'Session expired. Please refresh and try again.', [], 403);
}

$name = clean_input($_POST['name'] ?? '');
if ($name === '') {
    json_response(false, 'Please enter a cancer type name.');
}

$dupStmt = mysqli_prepare($con, 'SELECT `id` FROM `cancers` WHERE LOWER(`name`) = LOWER(?) LIMIT 1');
if ($dupStmt) {
    mysqli_stmt_bind_param($dupStmt, 's', $name);
    mysqli_stmt_execute($dupStmt);
    $dupRes = mysqli_stmt_get_result($dupStmt);
    $exists = $dupRes && mysqli_num_rows($dupRes) > 0;
    mysqli_stmt_close($dupStmt);
    if ($exists) {
        json_response(false, 'This cancer type already exists.');
    }
}

$num = generate_next_id($con, 'cancers', 'num', 'C');
$stmt = mysqli_prepare($con, 'INSERT INTO `cancers` (`num`, `name`) VALUES (?, ?)');
if (!$stmt) {
    json_response(false, 'Could not save cancer type.', [], 500);
}

mysqli_stmt_bind_param($stmt, 'ss', $num, $name);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if (!$ok) {
    json_response(false, 'Failed to register cancer type.', [], 500);
}

json_response(true, 'Cancer type (' . $num . ') registered successfully.', [
    'redirect' => 'cancers.php',
]);
