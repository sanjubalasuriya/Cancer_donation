<?php
/**
 * Centralized PHPMailer email helper with safe non-blocking error handling.
 */

require_once __DIR__ . '/../includes/PHPMailer.php';
require_once __DIR__ . '/../includes/SMTP.php';
require_once __DIR__ . '/../includes/Exception.php';
require_once __DIR__ . '/security.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Render a consistent, XSS-safe foundation email body.
 */
function build_foundation_email(string $recipientName, string $headline, string $bodyHtml): string
{
    $safeName = e($recipientName);
    $safeHeadline = e($headline);

    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body style="margin:0;padding:24px;background:#f8fafc;font-family:'Segoe UI',Arial,sans-serif;color:#1e293b;">
  <div style="max-width:560px;margin:0 auto;background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
    <div style="background:#b91c1c;color:#ffffff;padding:24px;text-align:center;">
      <h1 style="margin:0;font-size:22px;font-weight:600;">Save Life Cancer Foundation</h1>
      <p style="margin:6px 0 0;font-size:14px;opacity:0.9;">{$safeHeadline}</p>
    </div>
    <div style="padding:28px 24px;line-height:1.6;font-size:15px;">
      <p style="margin-top:0;">Dear {$safeName},</p>
      {$bodyHtml}
      <p style="margin-bottom:0;margin-top:24px;color:#475569;">With gratitude,<br><strong>Save Life Cancer Foundation</strong></p>
    </div>
  </div>
</body>
</html>
HTML;
}

/**
 * Send an email via SMTP. Never throws; logs and returns status array.
 *
 * @return array{sent: bool, error: ?string}
 */
function send_foundation_email(string $toEmail, string $subject, string $htmlBody, ?string $attachmentPath = null): array
{
    $config = require __DIR__ . '/../config/app.php';
    $smtp = $config['smtp'];

    if (empty($smtp['enabled'])) {
        return ['sent' => false, 'error' => 'SMTP sending is disabled in configuration.'];
    }

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $smtp['host'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = $smtp['encryption'];
        $mail->Port = $smtp['port'];
        $mail->Timeout = 8;
        $mail->Username = $smtp['username'];
        $mail->Password = $smtp['password'];

        $mail->setFrom($smtp['from_email'], $smtp['from_name']);
        $mail->addAddress($toEmail);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;

        if ($attachmentPath !== null && is_file($attachmentPath)) {
            $mail->addAttachment($attachmentPath);
        }

        $mail->send();
        $mail->smtpClose();
        return ['sent' => true, 'error' => null];
    } catch (Exception $e) {
        error_log('PHPMailer error (' . $toEmail . '): ' . $e->getMessage());
        return ['sent' => false, 'error' => $e->getMessage()];
    } catch (\Throwable $e) {
        error_log('Mail error (' . $toEmail . '): ' . $e->getMessage());
        return ['sent' => false, 'error' => $e->getMessage()];
    }
}
