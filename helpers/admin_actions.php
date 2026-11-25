<?php
/**
 * Shared admin helpers for safe deletion and record fetching.
 */

require_once __DIR__ . '/security.php';
require_once __DIR__ . '/response.php';

/**
 * Handle AJAX POST delete requests cleanly before any HTML output.
 */
function handle_admin_delete_request(mysqli $con, string $table, string $label): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['delete_btn_set'])) {
        return;
    }

    $allowed = ['patients', 'sponsors', 'cancers', 'event', 'news', 'salons'];
    if (!in_array($table, $allowed, true)) {
        json_response(false, 'Unsupported resource.', [], 400);
    }

    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        json_response(false, 'Session expired. Please refresh and try again.', [], 403);
    }

    $delId = filter_var($_POST['delete_id'] ?? null, FILTER_VALIDATE_INT);
    if (!$delId || $delId <= 0) {
        json_response(false, 'Invalid record ID.', [], 400);
    }

    if ($table === 'salons') {
        $fetch = mysqli_prepare($con, 'SELECT `s_id` FROM `salons` WHERE `id` = ? LIMIT 1');
        if ($fetch) {
            mysqli_stmt_bind_param($fetch, 'i', $delId);
            mysqli_stmt_execute($fetch);
            $res = mysqli_stmt_get_result($fetch);
            $salonRow = $res ? mysqli_fetch_assoc($res) : null;
            mysqli_stmt_close($fetch);

            if ($salonRow) {
                $delLogin = mysqli_prepare($con, "DELETE FROM `login` WHERE `uname` = ? AND `role` = 'salon'");
                if ($delLogin) {
                    mysqli_stmt_bind_param($delLogin, 's', $salonRow['s_id']);
                    mysqli_stmt_execute($delLogin);
                    mysqli_stmt_close($delLogin);
                }
            }
        }
    }

    $stmt = mysqli_prepare($con, "DELETE FROM `$table` WHERE `id` = ?");
    if (!$stmt) {
        json_response(false, 'Unable to delete ' . $label . ' right now.', [], 500);
    }

    mysqli_stmt_bind_param($stmt, 'i', $delId);
    $ok = mysqli_stmt_execute($stmt);
    $affected = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if (!$ok || $affected === 0) {
        json_response(false, $label . ' could not be deleted or was already removed.', [], 404);
    }

    json_response(true, $label . ' deleted successfully.');
}
