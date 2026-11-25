<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: profile.php');
    exit();
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    redirect_with_flash('profile.php', 'error', 'Session expired. Please try again.');
}

$uname = $_SESSION['uname'] ?? '';
$result = process_password_change(
    $con,
    $uname,
    (string)($_POST['password'] ?? ''),
    (string)($_POST['npass'] ?? ''),
    (string)($_POST['cpass'] ?? '')
);

redirect_with_flash('profile.php', $result['ok'] ? 'success' : 'error', $result['message']);
