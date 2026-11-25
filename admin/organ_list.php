<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/mailer.php';
require_once __DIR__ . '/../helpers/response.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_btn_set'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        json_response(false, 'Session expired. Please refresh and try again.', [], 403);
    }

    $reqId = filter_var($_POST['delete_id'] ?? null, FILTER_VALIDATE_INT);
    if (!$reqId || $reqId <= 0) {
        json_response(false, 'Invalid hair donation request ID.', [], 400);
    }

    $stmt = mysqli_prepare($con, 'SELECT `id`, `f_name`, `l_name`, `email`, `request` FROM `organ` WHERE `id` = ? LIMIT 1');
    if (!$stmt) {
        json_response(false, 'Unable to load hair donation request.', [], 500);
    }
    mysqli_stmt_bind_param($stmt, 'i', $reqId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $donor = $res ? mysqli_fetch_assoc($res) : null;
    mysqli_stmt_close($stmt);

    if (!$donor) {
        json_response(false, 'Hair donation request not found.', [], 404);
    }

    $fullName = trim($donor['f_name'] . ' ' . $donor['l_name']);
    $fontPath = __DIR__ . '/BRUSHSCI.TTF';
    $templatePath = __DIR__ . '/Certificate1.jpg';
    $certDir = __DIR__ . '/certificate';

    if (!is_dir($certDir) && !mkdir($certDir, 0755, true)) {
        json_response(false, 'Failed to prepare certificate output folder.', [], 500);
    }

    if (!is_file($templatePath) || !is_file($fontPath)) {
        json_response(false, 'Certificate template or font file is missing on the server.', [], 500);
    }

    if (!function_exists('imagecreatefromjpeg') || !function_exists('imagettftext')) {
        json_response(false, 'PHP GD with FreeType support is required to generate certificates.', [], 500);
    }

    $image = @imagecreatefromjpeg($templatePath);
    if (!$image) {
        json_response(false, 'Could not load certificate template image.', [], 500);
    }

    $color = imagecolorallocate($image, 19, 21, 22);
    $size = 180;
    $box = imagettfbbox($size, 0, $fontPath, $fullName);
    $textWidth = abs($box[2] - $box[0]);
    $textHeight = abs($box[5] - $box[3]);
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);
    $x = (int)(($imageWidth - $textWidth) / 2) + 250;
    $y = (int)(($imageHeight + $textHeight) / 2);

    imagettftext($image, $size, 0, $x, $y, $color, $fontPath, $fullName);

    $baseName = 'certificate_' . $reqId . '_' . time();
    $jpgPath = $certDir . DIRECTORY_SEPARATOR . $baseName . '.jpg';
    $pdfPath = $certDir . DIRECTORY_SEPARATOR . $baseName . '.pdf';

    imagejpeg($image, $jpgPath, 92);
    imagedestroy($image);

    require_once __DIR__ . '/fpdf.php';
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->Image($jpgPath, 0, 0, 210, 150);
    $pdf->Output($pdfPath, 'F');

    $bodyHtml = '<p>Thank you for your inspiring hair donation to Save Life Cancer Foundation.</p>'
        . '<p>Please find your official Certificate of Appreciation attached to this email.</p>';
    $htmlBody = build_foundation_email($fullName, 'Certificate of Appreciation', $bodyHtml);
    $mailResult = send_foundation_email($donor['email'], 'Save Life Foundation - Appreciation Certificate', $htmlBody, $pdfPath);

    $upd = mysqli_prepare($con, "UPDATE `organ` SET `request` = 'sent' WHERE `id` = ?");
    if ($upd) {
        mysqli_stmt_bind_param($upd, 'i', $reqId);
        mysqli_stmt_execute($upd);
        mysqli_stmt_close($upd);
    }

    $msg = $mailResult['sent']
        ? 'Certificate generated and emailed to ' . $donor['email'] . '.'
        : 'Certificate PDF generated and marked as sent (email delivery failed: ' . ($mailResult['error'] ?? 'SMTP unavailable') . ').';

    json_response(true, $msg, ['email_sent' => $mailResult['sent']]);
}

include __DIR__ . '/header.php';

$requests = [];
$res = mysqli_query($con, 'SELECT `id`, `salon_id`, `f_name`, `l_name`, `email`, `nic`, `request`, `date` FROM `organ` ORDER BY (`request` = "pending") DESC, `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $requests[] = $row;
    }
}
$csrf = csrf_token();
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Hair Donation Requests</h1>
    </div>
    <hr>

    <?php if (empty($requests)): ?>
        <div class="empty-state">
            <h3>No Hair Donation Requests</h3>
            <p>Requests submitted by partner salons will appear here for certificate generation.</p>
        </div>
    <?php else: ?>
        <div class="details_table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Salon</th>
                        <th>Donor Name</th>
                        <th>Email</th>
                        <th>NIC</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $row): ?>
                        <tr>
                            <td>#<?php echo (int)$row['id']; ?></td>
                            <td><strong><?php echo e($row['salon_id']); ?></strong></td>
                            <td><?php echo e($row['f_name'] . ' ' . $row['l_name']); ?></td>
                            <td><?php echo e($row['email']); ?></td>
                            <td><?php echo e($row['nic']); ?></td>
                            <td>
                                <span class="badge <?php echo $row['request'] === 'sent' ? 'badge-success' : 'badge-warning'; ?>">
                                    <?php echo e($row['request']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($row['request'] === 'pending'): ?>
                                    <button type="button"
                                            class="action edit js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Send Certificate?"
                                            data-text="Generate and email PDF certificate to <?php echo e($row['email']); ?>?"
                                            data-confirm-text="Send PDF">
                                        Send Certificate
                                    </button>
                                <?php else: ?>
                                    <button type="button"
                                            class="action secondary js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Resend Certificate?"
                                            data-text="Regenerate and resend PDF certificate to <?php echo e($row['email']); ?>?"
                                            data-confirm-text="Resend">
                                        Resend
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
