<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$cancer = null;

if ($id && $id > 0) {
    $stmt = mysqli_prepare($con, 'SELECT `id`, `num`, `name` FROM `cancers` WHERE `id` = ? LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $cancer = $res ? mysqli_fetch_assoc($res) : null;
        mysqli_stmt_close($stmt);
    }
}

$errorMsg = '';
$successMsg = '';

if ($cancer && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cupdate'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } else {
        $name = clean_input($_POST['name'] ?? '');
        if ($name === '') {
            $errorMsg = 'Cancer name is required.';
        } else {
            $upd = mysqli_prepare($con, 'UPDATE `cancers` SET `name` = ? WHERE `id` = ?');
            if ($upd) {
                mysqli_stmt_bind_param($upd, 'si', $name, $id);
                if (mysqli_stmt_execute($upd)) {
                    $successMsg = 'Cancer type updated successfully.';
                    $cancer['name'] = $name;
                } else {
                    $errorMsg = 'Failed to update cancer type.';
                }
                mysqli_stmt_close($upd);
            }
        }
    }
}

include __DIR__ . '/header.php';
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Edit Cancer Type</h1>
        <a href="cancers.php" class="btn btn-secondary">Back to Cancers</a>
    </div>
    <hr>

    <?php if (!$cancer): ?>
        <div class="empty-state">
            <h3>Cancer Type Not Found</h3>
            <p>The requested record does not exist.</p>
            <a href="cancers.php" class="btn">Return to Cancers</a>
        </div>
    <?php else: ?>
        <?php if ($errorMsg !== ''): ?>
            <div class="alert alert-danger" role="alert"><?php echo e($errorMsg); ?></div>
        <?php endif; ?>
        <?php if ($successMsg !== ''): ?>
            <div class="alert alert-success" role="alert"><?php echo e($successMsg); ?></div>
        <?php endif; ?>

        <div class="content_form">
            <form method="POST">
                <?php echo csrf_field(); ?>
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels" for="num">Cancer Code</label>
                        <input type="text" id="num" name="num" value="<?php echo e($cancer['num']); ?>" readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="name">Cancer Name</label>
                        <input type="text" id="name" name="name" value="<?php echo e($cancer['name']); ?>" required>
                    </div>
                </div>

                <div class="button">
                    <button type="submit" class="btn" name="cupdate" id="cupdate">Save Changes</button>
                    <a href="cancers.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
