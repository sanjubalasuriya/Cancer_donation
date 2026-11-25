<?php
/**
 * Input validation and safe file upload helpers.
 */

function clean_input(?string $value): string
{
    return trim((string)$value);
}

function is_valid_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function is_valid_phone(string $phone): bool
{
    return preg_match('/^[0-9]{10}$/', $phone) === 1;
}

function is_valid_nic(string $nic): bool
{
    return preg_match('/^(?:[0-9]{9}[vVxX]|[0-9]{12})$/', $nic) === 1;
}

function is_positive_number($value): bool
{
    return is_numeric($value) && (float)$value > 0;
}

function is_valid_coordinate($value, float $min, float $max): bool
{
    if (!is_numeric($value)) {
        return false;
    }
    $floatVal = (float)$value;
    return $floatVal >= $min && $floatVal <= $max;
}

/**
 * Validate and store an uploaded image file safely.
 *
 * @return array{ok: bool, path: ?string, error: ?string}
 */
function handle_image_upload(array $file, string $targetDirAbs, string $webPrefix, bool $required = false): array
{
    $config = require __DIR__ . '/../config/app.php';
    $maxBytes = $config['uploads']['max_bytes'];
    $allowedExts = $config['uploads']['allowed_extensions'];

    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        if ($required) {
            return ['ok' => false, 'path' => null, 'error' => 'Please select an image file to upload.'];
        }
        return ['ok' => true, 'path' => null, 'error' => null];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'path' => null, 'error' => 'File upload failed. Please try again.'];
    }

    if (!is_uploaded_file($file['tmp_name'])) {
        return ['ok' => false, 'path' => null, 'error' => 'Invalid upload source.'];
    }

    if ($file['size'] <= 0 || $file['size'] > $maxBytes) {
        return ['ok' => false, 'path' => null, 'error' => 'Image must be smaller than 5 MB.'];
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExts, true)) {
        return ['ok' => false, 'path' => null, 'error' => 'Only JPG, JPEG, PNG, WEBP, and GIF images are allowed.'];
    }

    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = $finfo ? finfo_file($finfo, $file['tmp_name']) : '';
        if ($finfo) {
            finfo_close($finfo);
        }
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($mime, $allowedMimes, true)) {
            return ['ok' => false, 'path' => null, 'error' => 'Uploaded file is not a valid image.'];
        }
    }

    if (!is_dir($targetDirAbs) && !mkdir($targetDirAbs, 0755, true)) {
        return ['ok' => false, 'path' => null, 'error' => 'Could not create upload directory.'];
    }

    $filename = bin2hex(random_bytes(12)) . '.' . $ext;
    $destAbs = rtrim($targetDirAbs, '/\\') . DIRECTORY_SEPARATOR . $filename;
    if (!move_uploaded_file($file['tmp_name'], $destAbs)) {
        return ['ok' => false, 'path' => null, 'error' => 'Failed to save uploaded image.'];
    }

    return [
        'ok' => true,
        'path' => rtrim($webPrefix, '/') . '/' . $filename,
        'error' => null,
    ];
}
