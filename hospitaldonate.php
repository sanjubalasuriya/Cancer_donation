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
$status = clean_input($_POST['status'] ?? '');
$amountRaw = clean_input($_POST['amount'] ?? '');

if ($f_name === '' || $l_name === '' || $email === '' || $contact === '' || $status === '' || $amountRaw === '') {
    json_response(false, 'Please fill in all required fields.');
}

if (!is_valid_phone($contact)) {
    json_response(false, 'Contact number must be a valid 10-digit phone number.');
}

if (!is_valid_email($email)) {
    json_response(false, 'Please enter a valid email address.');
}

if (!is_positive_number($amountRaw)) {
    json_response(false, 'Donation amount must be greater than zero.');
}

$amount = (int)$amountRaw;
$donorId = generate_next_id($con, 'donor', 'd_id', 'D');

mysqli_begin_transaction($con);

try {
    $stmt1 = mysqli_prepare($con, 'INSERT INTO `donor` (`d_id`, `f_name`, `l_name`, `email`, `contact`, `status`) VALUES (?, ?, ?, ?, ?, ?)');
    if (!$stmt1) {
        throw new RuntimeException('Failed to prepare donor insert.');
    }
    mysqli_stmt_bind_param($stmt1, 'ssssss', $donorId, $f_name, $l_name, $email, $contact, $status);
    if (!mysqli_stmt_execute($stmt1)) {
        throw new RuntimeException('Failed to save donor details.');
    }
    mysqli_stmt_close($stmt1);

    $stmt2 = mysqli_prepare($con, 'INSERT INTO `donations` (`key_id`, `status`, `amount`) VALUES (?, ?, ?)');
    if (!$stmt2) {
        throw new RuntimeException('Failed to prepare donation insert.');
    }
    mysqli_stmt_bind_param($stmt2, 'ssi', $donorId, $status, $amount);
    if (!mysqli_stmt_execute($stmt2)) {
        throw new RuntimeException('Failed to save donation record.');
    }
    mysqli_stmt_close($stmt2);

    mysqli_commit($con);
} catch (\Throwable $e) {
    mysqli_rollback($con);
    error_log('Hospital donation error: ' . $e->getMessage());
    json_response(false, 'Could not record your donation right now. Please try again.', [], 500);
}

$bodyHtml = '<p>Thank you for your generous donation of <strong>Rs. ' . number_format($amount) . '</strong> toward <strong>' . e($status) . '</strong>.</p>'
    . '<p>Your contribution helps Save Life Cancer Foundation strengthen patient care and hospital facilities.</p>';
$htmlBody = build_foundation_email($f_name . ' ' . $l_name, 'Hospital Donation Confirmation', $bodyHtml);
$mailResult = send_foundation_email($email, 'Save Life Foundation - Donation Receipt', $htmlBody);

$msg = $mailResult['sent']
    ? 'Thank you for your donation of Rs. ' . number_format($amount) . '! A confirmation email has been sent.'
    : 'Thank you for your donation of Rs. ' . number_format($amount) . '! Your donation has been recorded.';

json_response(true, $msg, [
    'redirect' => 'hospital.php',
    'email_sent' => $mailResult['sent'],
]);
