<?php
/**
 * Shared authentication and password management helpers.
 * Transparently supports legacy MD5 hashes and upgrades them to password_hash().
 */

function verify_user_password(string $plainPassword, string $storedHash): bool
{
    if ($storedHash === '') {
        return false;
    }

    if (password_get_info($storedHash)['algo'] !== null) {
        return password_verify($plainPassword, $storedHash);
    }

    // Legacy MD5 fallback
    return hash_equals(strtolower($storedHash), md5($plainPassword));
}

function hash_user_password(string $plainPassword): string
{
    return password_hash($plainPassword, PASSWORD_DEFAULT);
}

function upgrade_password_if_legacy(mysqli $con, int $userId, string $plainPassword, string $storedHash): void
{
    if (password_get_info($storedHash)['algo'] === null || password_needs_rehash($storedHash, PASSWORD_DEFAULT)) {
        $newHash = hash_user_password($plainPassword);
        $stmt = mysqli_prepare($con, 'UPDATE `login` SET `password` = ? WHERE `id` = ?');
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'si', $newHash, $userId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}

/**
 * Process a password change request for the currently authenticated user.
 *
 * @return array{ok: bool, message: string}
 */
function process_password_change(mysqli $con, string $uname, string $currentPass, string $newPass, string $confirmPass): array
{
    if ($currentPass === '') {
        return ['ok' => false, 'message' => 'Current password is required.'];
    }
    if ($newPass === '') {
        return ['ok' => false, 'message' => 'New password is required.'];
    }
    if (strlen($newPass) < 6) {
        return ['ok' => false, 'message' => 'New password must be at least 6 characters long.'];
    }
    if ($newPass !== $confirmPass) {
        return ['ok' => false, 'message' => 'Confirm password does not match.'];
    }

    $stmt = mysqli_prepare($con, 'SELECT `id`, `password` FROM `login` WHERE `uname` = ? LIMIT 1');
    if (!$stmt) {
        return ['ok' => false, 'message' => 'Could not verify your account right now.'];
    }

    mysqli_stmt_bind_param($stmt, 's', $uname);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $user = $res ? mysqli_fetch_assoc($res) : null;
    mysqli_stmt_close($stmt);

    if (!$user || !verify_user_password($currentPass, $user['password'])) {
        return ['ok' => false, 'message' => 'Incorrect current password.'];
    }

    $hashed = hash_user_password($newPass);
    $upd = mysqli_prepare($con, 'UPDATE `login` SET `password` = ? WHERE `id` = ?');
    if (!$upd) {
        return ['ok' => false, 'message' => 'Failed to update password.'];
    }
    mysqli_stmt_bind_param($upd, 'si', $hashed, $user['id']);
    $ok = mysqli_stmt_execute($upd);
    mysqli_stmt_close($upd);

    if (!$ok) {
        return ['ok' => false, 'message' => 'Database error while updating password.'];
    }

    return ['ok' => true, 'message' => 'Your password has been updated successfully.'];
}
