<?php
require_once __DIR__ . '/helpers/security.php';
require_once __DIR__ . '/helpers/auth.php';
require_once __DIR__ . '/db/db.php';

start_secure_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['login_btn'])) {
    header('Location: login.php');
    exit();
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    redirect_with_flash('login.php', 'status', 'Session expired. Please try signing in again.');
}

$uname = trim((string)($_POST['uname'] ?? ''));
$password = (string)($_POST['password'] ?? '');

if ($uname === '' || $password === '') {
    redirect_with_flash('login.php', 'status', 'Please enter both username and password.');
}

$stmt = mysqli_prepare($con, 'SELECT `id`, `uname`, `password`, `role` FROM `login` WHERE `uname` = ? LIMIT 1');
if (!$stmt) {
    redirect_with_flash('login.php', 'status', 'Unable to process login right now.');
}

mysqli_stmt_bind_param($stmt, 's', $uname);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$user = $res ? mysqli_fetch_assoc($res) : null;
mysqli_stmt_close($stmt);

if (!$user || !verify_user_password($password, $user['password'])) {
    redirect_with_flash('login.php', 'status', 'Invalid username or password.');
}

upgrade_password_if_legacy($con, (int)$user['id'], $password, $user['password']);

session_regenerate_id(true);
$_SESSION['uname'] = $user['uname'];
$_SESSION['role'] = $user['role'];

if ($user['role'] === 'admin') {
    header('Location: admin/index.php');
    exit();
}

if ($user['role'] === 'salon') {
    header('Location: salon/index.php');
    exit();
}

session_unset();
session_destroy();
redirect_with_flash('login.php', 'status', 'Account role is not configured.');
