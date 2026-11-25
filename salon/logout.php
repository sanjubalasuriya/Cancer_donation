<?php
require_once __DIR__ . '/../helpers/security.php';

start_secure_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
}

header('Location: ../login.php');
exit();
