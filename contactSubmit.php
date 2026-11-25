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
    json_response(false, 'Your session expired. Please refresh the page and try again.', [], 403);
}

$name = clean_input($_POST['name'] ?? '');
$email = clean_input($_POST['email'] ?? '');
$message = clean_input($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    json_response(false, 'Please fill in your name, email, and message.');
}

if (!is_valid_email($email)) {
    json_response(false, 'Please enter a valid email address.');
}

$stmt = mysqli_prepare($con, 'INSERT INTO `enquiries` (`name`, `email`, `message`) VALUES (?, ?, ?)');
if (!$stmt) {
    json_response(false, 'Unable to save your enquiry right now.', [], 500);
}

mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $message);
$saved = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if (!$saved) {
    json_response(false, 'Could not submit your enquiry. Please try again.', [], 500);
}

$appConfig = require __DIR__ . '/config/app.php';
$adminEmail = $appConfig['smtp']['admin_notify_email'];

$bodyHtml = '<p>A new online enquiry was submitted via the Save Life Contact page.</p>'
    . '<p><strong>From:</strong> ' . e($name) . ' (' . e($email) . ')</p>'
    . '<p><strong>Message:</strong><br>' . nl2br(e($message)) . '</p>';

$emailHtml = build_foundation_email('Foundation Team', 'New Online Enquiry', $bodyHtml);
$mailResult = send_foundation_email($adminEmail, 'New Enquiry from ' . $name, $emailHtml);

$replyText = $mailResult['sent']
    ? 'Thank you! Your enquiry has been saved and forwarded to our team.'
    : 'Thank you! Your enquiry has been saved. Our team will review it shortly.';

json_response(true, $replyText, ['email_sent' => $mailResult['sent']]);
