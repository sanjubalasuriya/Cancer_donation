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
$amountRaw = clean_input($_POST['amount'] ?? '');
$iid = filter_var($_POST['iid'] ?? null, FILTER_VALIDATE_INT);

if ($f_name === '' || $l_name === '' || $email === '' || $contact === '' || $amountRaw === '' || !$iid || $iid <= 0) {
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

$pStmt = mysqli_prepare($con, 'SELECT `id`, `p_id`, `f_name`, `l_name` FROM `patients` WHERE `id` = ? LIMIT 1');
if (!$pStmt) {
    json_response(false, 'Unable to verify patient record right now.', [], 500);
}
mysqli_stmt_bind_param($pStmt, 'i', $iid);
mysqli_stmt_execute($pStmt);
$pRes = mysqli_stmt_get_result($pStmt);
$patient = $pRes ? mysqli_fetch_assoc($pRes) : null;
mysqli_stmt_close($pStmt);

if (!$patient) {
    json_response(false, 'Selected patient record was not found.', [], 404);
}

$p_id = $patient['p_id'];
$patientFullName = trim($patient['f_name'] . ' ' . $patient['l_name']);
$donorId = generate_next_id($con, 'donor', 'd_id', 'D');

mysqli_begin_transaction($con);

try {
    $stmt1 = mysqli_prepare($con, 'INSERT INTO `donor` (`d_id`, `f_name`, `l_name`, `email`, `contact`, `status`) VALUES (?, ?, ?, ?, ?, ?)');
    if (!$stmt1) {
        throw new RuntimeException('Failed to prepare donor insert.');
    }
    mysqli_stmt_bind_param($stmt1, 'ssssss', $donorId, $f_name, $l_name, $email, $contact, $p_id);
    if (!mysqli_stmt_execute($stmt1)) {
        throw new RuntimeException('Failed to save donor details.');
    }
    mysqli_stmt_close($stmt1);

    $donationType = 'patients';
    $stmt2 = mysqli_prepare($con, 'INSERT INTO `donations` (`key_id`, `status`, `amount`) VALUES (?, ?, ?)');
    if (!$stmt2) {
        throw new RuntimeException('Failed to prepare donation insert.');
    }
    mysqli_stmt_bind_param($stmt2, 'ssi', $donorId, $donationType, $amount);
    if (!mysqli_stmt_execute($stmt2)) {
        throw new RuntimeException('Failed to save donation.');
    }
    mysqli_stmt_close($stmt2);

    $stmt3 = mysqli_prepare($con, 'UPDATE `patients` SET `donate` = `donate` + ? WHERE `id` = ?');
    if (!$stmt3) {
        throw new RuntimeException('Failed to prepare patient update.');
    }
    mysqli_stmt_bind_param($stmt3, 'ii', $amount, $iid);
    if (!mysqli_stmt_execute($stmt3)) {
        throw new RuntimeException('Failed to update patient funding.');
    }
    mysqli_stmt_close($stmt3);

    mysqli_commit($con);
} catch (\Throwable $e) {
    mysqli_rollback($con);
    error_log('Patient transfer error: ' . $e->getMessage());
    json_response(false, 'Could not process your donation right now. Please try again.', [], 500);
}

$bodyHtml = '<p>Thank you for your generous donation of <strong>Rs. ' . number_format($amount) . '</strong> toward treatment for <strong>' . e($patientFullName) . '</strong> (' . e($p_id) . ').</p>'
    . '<p>Your kindness directly supports urgent medical care.</p>';
$htmlBody = build_foundation_email($f_name . ' ' . $l_name, 'Patient Donation Receipt', $bodyHtml);
$mailResult = send_foundation_email($email, 'Save Life Foundation - Patient Donation Receipt', $htmlBody);

$msg = $mailResult['sent']
    ? 'Thank you for donating Rs. ' . number_format($amount) . ' to ' . $patientFullName . '! A receipt has been emailed to you.'
    : 'Thank you for donating Rs. ' . number_format($amount) . ' to ' . $patientFullName . '! Your donation has been recorded.';

json_response(true, $msg, [
    'redirect' => 'money.php',
    'email_sent' => $mailResult['sent'],
]);
