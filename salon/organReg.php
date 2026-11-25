<?php
require_once __DIR__ . '/../helpers/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';
require_once __DIR__ . '/../helpers/mailer.php';
require_once __DIR__ . '/../helpers/response.php';

start_secure_session();

if (empty($_SESSION['uname']) || ($_SESSION['role'] ?? '') !== 'salon') {
    json_response(false, 'Unauthorized. Please sign in as a salon partner.', [], 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method not allowed.', [], 405);
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response(false, 'Session expired. Please refresh the page and try again.', [], 403);
}

$salonId = $_SESSION['uname'];
$f_name = clean_input($_POST['f_name'] ?? '');
$l_name = clean_input($_POST['l_name'] ?? '');
$email = clean_input($_POST['email'] ?? '');
$dob = clean_input($_POST['dob'] ?? '');
$contact = clean_input($_POST['contact'] ?? '');
$nic = clean_input($_POST['nic'] ?? '');
$gender = clean_input($_POST['gender'] ?? '');

if ($f_name === '' || $l_name === '' || $email === '' || $contact === '' || $nic === '' || $dob === '' || $gender === '') {
    json_response(false, 'Please fill in all required fields.');
}

if (!is_valid_phone($contact)) {
    json_response(false, 'Contact number must be a valid 10-digit phone number.');
}

if (!is_valid_email($email)) {
    json_response(false, 'Please enter a valid email address.');
}

if (!is_valid_nic($nic)) {
    json_response(false, 'Please enter a valid NIC number (e.g. 901711671V or 12 digits).');
}

if (!in_array($gender, ['Male', 'Female'], true)) {
    json_response(false, 'Please select a valid gender.');
}

$statusPending = 'pending';
$stmt = mysqli_prepare(
    $con,
    'INSERT INTO `organ` (`salon_id`, `f_name`, `l_name`, `email`, `contact`, `nic`, `dob`, `gender`, `request`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
);
if (!$stmt) {
    json_response(false, 'Unable to register hair donation right now.', [], 500);
}

mysqli_stmt_bind_param($stmt, 'sssssssss', $salonId, $f_name, $l_name, $email, $contact, $nic, $dob, $gender, $statusPending);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if (!$ok) {
    error_log('Hair donation insert error: ' . mysqli_error($con));
    json_response(false, 'Failed to save hair donation request. Please try again.', [], 500);
}

$bodyHtml = '<p>Thank you for donating hair through our partner salon (<strong>' . e($salonId) . '</strong>).</p>'
    . '<p>Your request has been received and your appreciation certificate will be sent once approved by Save Life Cancer Foundation.</p>';
$htmlBody = build_foundation_email($f_name . ' ' . $l_name, 'Hair Donation Request Received', $bodyHtml);
$mailResult = send_foundation_email($email, 'Save Life Foundation - Hair Donation Received', $htmlBody);

$msg = $mailResult['sent']
    ? 'Hair donation request submitted and confirmation email sent to donor.'
    : 'Hair donation request submitted successfully.';

json_response(true, $msg, [
    'redirect' => 'index.php',
    'email_sent' => $mailResult['sent'],
]);
