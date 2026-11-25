<?php
require_once __DIR__ . '/../helpers/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';
require_once __DIR__ . '/../helpers/id_generator.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/mailer.php';
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
$address = clean_input($_POST['address'] ?? '');
$latRaw = clean_input($_POST['lat'] ?? '');
$lngRaw = clean_input($_POST['lng'] ?? '');
$email = clean_input($_POST['email'] ?? '');
$lisence = clean_input($_POST['lisence'] ?? '');
$contact = clean_input($_POST['contact'] ?? '');

if ($name === '' || $address === '' || $latRaw === '' || $lngRaw === '' || $email === '' || $lisence === '' || $contact === '') {
    json_response(false, 'Please fill in all required fields.');
}

if (!is_valid_coordinate($latRaw, -90.0, 90.0) || !is_valid_coordinate($lngRaw, -180.0, 180.0)) {
    json_response(false, 'Please enter valid latitude (-90 to 90) and longitude (-180 to 180) coordinates.');
}

if (!is_valid_phone($contact)) {
    json_response(false, 'Contact number must be exactly 10 digits.');
}

if (!is_valid_email($email)) {
    json_response(false, 'Please enter a valid email address.');
}

$s_id = generate_next_id($con, 'salons', 's_id', 'SL_');
$lat = (float)$latRaw;
$lng = (float)$lngRaw;
$defaultPassword = '123456';
$hashedPass = hash_user_password($defaultPassword);
$roleSalon = 'salon';

mysqli_begin_transaction($con);

try {
    $stmt1 = mysqli_prepare(
        $con,
        'INSERT INTO `salons` (`s_id`, `name`, `address`, `lat`, `lng`, `email`, `lisence`, `contact`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    );
    if (!$stmt1) {
        throw new RuntimeException('Failed to prepare salon insert.');
    }
    mysqli_stmt_bind_param($stmt1, 'sssddsss', $s_id, $name, $address, $lat, $lng, $email, $lisence, $contact);
    if (!mysqli_stmt_execute($stmt1)) {
        throw new RuntimeException('Failed to save salon.');
    }
    mysqli_stmt_close($stmt1);

    $stmt2 = mysqli_prepare($con, 'INSERT INTO `login` (`uname`, `password`, `role`) VALUES (?, ?, ?)');
    if (!$stmt2) {
        throw new RuntimeException('Failed to prepare login insert.');
    }
    mysqli_stmt_bind_param($stmt2, 'sss', $s_id, $hashedPass, $roleSalon);
    if (!mysqli_stmt_execute($stmt2)) {
        throw new RuntimeException('Failed to create salon login account.');
    }
    mysqli_stmt_close($stmt2);

    mysqli_commit($con);
} catch (\Throwable $e) {
    mysqli_rollback($con);
    error_log('Salon registration error: ' . $e->getMessage());
    json_response(false, 'Could not register salon right now. Please try again.', [], 500);
}

$bodyHtml = '<p>Congratulations! Your salon has been registered as a hair donation partner with Save Life Cancer Foundation.</p>'
    . '<p><strong>Portal Username:</strong> ' . e($s_id) . '<br><strong>Temporary Password:</strong> ' . e($defaultPassword) . '</p>'
    . '<p>Please sign in and update your password from the Profile page.</p>';
$htmlBody = build_foundation_email($name, 'Partner Salon Account Created', $bodyHtml);
$mailResult = send_foundation_email($email, 'Save Life Foundation - Partner Salon Account', $htmlBody);

$msg = $mailResult['sent']
    ? 'Salon ' . $name . ' (' . $s_id . ') registered and credentials emailed.'
    : 'Salon ' . $name . ' (' . $s_id . ') registered successfully (default password: 123456).';

json_response(true, $msg, [
    'redirect' => 'salons.php',
    'email_sent' => $mailResult['sent'],
]);
