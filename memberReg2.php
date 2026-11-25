<?php
require_once __DIR__ . '/db/db.php';
require_once __DIR__ . '/helpers/security.php';
require_once __DIR__ . '/helpers/validation.php';
require_once __DIR__ . '/helpers/mailer.php';
require_once __DIR__ . '/helpers/response.php';

start_secure_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method not allowed.', [], 405);
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response(false, 'Session expired. Please refresh the page and try again.', [], 403);
}

$email = clean_input($_POST['email1'] ?? '');
$nic = clean_input($_POST['nic1'] ?? '');
$amount = 1000;

if ($email === '' || $nic === '') {
    json_response(false, 'Please enter both your registered NIC and email address.');
}

if (!is_valid_email($email)) {
    json_response(false, 'Please enter a valid email address.');
}

$stmt = mysqli_prepare($con, 'SELECT `m_id`, `f_name`, `l_name`, `email` FROM `members` WHERE LOWER(`nic`) = LOWER(?) LIMIT 1');
if (!$stmt) {
    json_response(false, 'Unable to look up membership right now.', [], 500);
}
mysqli_stmt_bind_param($stmt, 's', $nic);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$member = $res ? mysqli_fetch_assoc($res) : null;
mysqli_stmt_close($stmt);

if (!$member) {
    json_response(false, 'No registered member was found with that NIC. Please register as a new member above.');
}

if (strcasecmp($member['email'], $email) !== 0) {
    json_response(false, 'The email address does not match the email registered for this NIC.');
}

$m_id = $member['m_id'];
$fullName = trim($member['f_name'] . ' ' . $member['l_name']);

mysqli_begin_transaction($con);

try {
    $donationType = 'member';
    $ins = mysqli_prepare($con, 'INSERT INTO `donations` (`key_id`, `status`, `amount`) VALUES (?, ?, ?)');
    if (!$ins) {
        throw new RuntimeException('Failed to prepare renewal insert.');
    }
    mysqli_stmt_bind_param($ins, 'ssi', $m_id, $donationType, $amount);
    if (!mysqli_stmt_execute($ins)) {
        throw new RuntimeException('Failed to insert renewal record.');
    }
    mysqli_stmt_close($ins);

    $upd = mysqli_prepare($con, "UPDATE `members` SET `status` = 'paid' WHERE `m_id` = ?");
    if ($upd) {
        mysqli_stmt_bind_param($upd, 's', $m_id);
        mysqli_stmt_execute($upd);
        mysqli_stmt_close($upd);
    }

    mysqli_commit($con);
} catch (\Throwable $e) {
    mysqli_rollback($con);
    error_log('Member renewal error: ' . $e->getMessage());
    json_response(false, 'Could not renew membership right now. Please try again.', [], 500);
}

$bodyHtml = '<p>Congratulations! Your Save Life Cancer Foundation membership (ID: <strong>' . e($m_id) . '</strong>) has been renewed for another year.</p>'
    . '<p>Renewal payment recorded: <strong>Rs. ' . number_format($amount) . '</strong>.</p>';
$htmlBody = build_foundation_email($fullName, 'Membership Renewed', $bodyHtml);
$mailResult = send_foundation_email($email, 'Save Life Foundation - Membership Renewed', $htmlBody);

$msg = $mailResult['sent']
    ? 'Membership renewed successfully! A confirmation email has been sent.'
    : 'Membership renewed successfully!';

json_response(true, $msg, [
    'redirect' => 'member.php',
    'email_sent' => $mailResult['sent'],
]);
