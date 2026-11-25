<?php
require_once __DIR__ . '/db/db.php';
require_once __DIR__ . '/helpers/security.php';
require_once __DIR__ . '/helpers/validation.php';
require_once __DIR__ . '/helpers/id_generator.php';
require_once __DIR__ . '/helpers/mailer.php';
require_once __DIR__ . '/helpers/response.php';

start_secure_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method not allowed.', [], 405);
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response(false, 'Session expired. Please refresh the page and try again.', [], 403);
}

$f_name = clean_input($_POST['f_name'] ?? '');
$l_name = clean_input($_POST['l_name'] ?? '');
$email = clean_input($_POST['email'] ?? '');
$contact = clean_input($_POST['contact'] ?? '');
$nic = clean_input($_POST['nic'] ?? '');
$amount = 1000; // Fixed annual membership fee

if ($f_name === '' || $l_name === '' || $email === '' || $contact === '' || $nic === '') {
    json_response(false, 'Please fill in all required fields.');
}

if (!is_valid_nic($nic)) {
    json_response(false, 'Please enter a valid NIC number (e.g. 901711671V or 12 digits).');
}

if (!is_valid_phone($contact)) {
    json_response(false, 'Contact number must be a valid 10-digit phone number.');
}

if (!is_valid_email($email)) {
    json_response(false, 'Please enter a valid email address.');
}

$checkStmt = mysqli_prepare($con, 'SELECT `id` FROM `members` WHERE LOWER(`nic`) = LOWER(?) LIMIT 1');
if (!$checkStmt) {
    json_response(false, 'Unable to check existing membership right now.', [], 500);
}
mysqli_stmt_bind_param($checkStmt, 's', $nic);
mysqli_stmt_execute($checkStmt);
$checkRes = mysqli_stmt_get_result($checkStmt);
$exists = $checkRes && mysqli_num_rows($checkRes) > 0;
mysqli_stmt_close($checkStmt);

if ($exists) {
    json_response(false, 'This NIC is already registered. Please use the Renew Membership form below.');
}

$m_id = generate_next_id($con, 'members', 'm_id', 'M');

mysqli_begin_transaction($con);

try {
    $statusPaid = 'paid';
    $stmt1 = mysqli_prepare($con, 'INSERT INTO `members` (`m_id`, `f_name`, `l_name`, `email`, `contact`, `nic`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?)');
    if (!$stmt1) {
        throw new RuntimeException('Failed to prepare member insert.');
    }
    mysqli_stmt_bind_param($stmt1, 'sssssss', $m_id, $f_name, $l_name, $email, $contact, $nic, $statusPaid);
    if (!mysqli_stmt_execute($stmt1)) {
        throw new RuntimeException('Failed to save member details.');
    }
    mysqli_stmt_close($stmt1);

    $donationType = 'member';
    $stmt2 = mysqli_prepare($con, 'INSERT INTO `donations` (`key_id`, `status`, `amount`) VALUES (?, ?, ?)');
    if (!$stmt2) {
        throw new RuntimeException('Failed to prepare donation insert.');
    }
    mysqli_stmt_bind_param($stmt2, 'ssi', $m_id, $donationType, $amount);
    if (!mysqli_stmt_execute($stmt2)) {
        throw new RuntimeException('Failed to save membership donation.');
    }
    mysqli_stmt_close($stmt2);

    mysqli_commit($con);
} catch (\Throwable $e) {
    mysqli_rollback($con);
    error_log('Member registration error: ' . $e->getMessage());
    json_response(false, 'Could not complete membership registration. Please try again.', [], 500);
}

$bodyHtml = '<p>Congratulations! You are now a registered member of Save Life Cancer Foundation (Member ID: <strong>' . e($m_id) . '</strong>).</p>'
    . '<p>Your annual membership fee of <strong>Rs. ' . number_format($amount) . '</strong> has been recorded and is valid for 1 year.</p>';
$htmlBody = build_foundation_email($f_name . ' ' . $l_name, 'Welcome to Save Life Membership', $bodyHtml);
$mailResult = send_foundation_email($email, 'Save Life Foundation - Membership Confirmed', $htmlBody);

$msg = $mailResult['sent']
    ? 'Welcome aboard! Your membership (' . $m_id . ') is active and a confirmation email has been sent.'
    : 'Welcome aboard! Your membership (' . $m_id . ') is now active.';

json_response(true, $msg, [
    'redirect' => 'member.php',
    'email_sent' => $mailResult['sent'],
]);
