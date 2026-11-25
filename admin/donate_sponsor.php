<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$sponsor = null;

if ($id && $id > 0) {
    $stmt = mysqli_prepare($con, 'SELECT `id`, `s_id`, `company` FROM `sponsors` WHERE `id` = ? LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $sponsor = $res ? mysqli_fetch_assoc($res) : null;
        mysqli_stmt_close($stmt);
    }
}

$errorMsg = '';
$successMsg = '';

if ($sponsor && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dregister'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } else {
        $amountRaw = clean_input($_POST['amount'] ?? '');
        if (!is_positive_number($amountRaw)) {
            $errorMsg = 'Donation amount must be greater than zero.';
        } else {
            $amount = (int)$amountRaw;
            $status = 'sponsor';
            $s_id = $sponsor['s_id'];

            $ins = mysqli_prepare($con, 'INSERT INTO `donations` (`key_id`, `status`, `amount`) VALUES (?, ?, ?)');
            if ($ins) {
                mysqli_stmt_bind_param($ins, 'ssi', $s_id, $status, $amount);
                if (mysqli_stmt_execute($ins)) {
                    $successMsg = 'Recorded sponsor donation of Rs. ' . number_format($amount) . '.';
                } else {
                    $errorMsg = 'Failed to record donation.';
                }
                mysqli_stmt_close($ins);
            }
        }
    }
}

include __DIR__ . '/header.php';

$records = [];
if ($sponsor) {
    $recStmt = mysqli_prepare($con, 'SELECT `id`, `key_id`, `status`, `amount`, `date` FROM `donations` WHERE `key_id` = ? ORDER BY `id` DESC');
    if ($recStmt) {
        mysqli_stmt_bind_param($recStmt, 's', $sponsor['s_id']);
        mysqli_stmt_execute($recStmt);
        $recRes = mysqli_stmt_get_result($recStmt);
        if ($recRes) {
            while ($r = mysqli_fetch_assoc($recRes)) {
                $records[] = $r;
            }
        }
        mysqli_stmt_close($recStmt);
    }
}
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Sponsor Donation<?php echo $sponsor ? ' - ' . e($sponsor['company']) : ''; ?></h1>
        <a href="sponsors.php" class="btn btn-secondary">Back to Sponsors</a>
    </div>
    <hr>

    <?php if (!$sponsor): ?>
        <div class="empty-state">
            <h3>Sponsor Not Found</h3>
            <p>Select a sponsor from the sponsors directory to record a donation.</p>
            <a href="sponsors.php" class="btn">Return to Sponsors</a>
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
                        <label class="labels" for="m_id">Sponsor ID</label>
                        <input type="text" id="m_id" name="m_id" value="<?php echo e($sponsor['s_id']); ?>" readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="amount">Donation Amount (Rs.)</label>
                        <input type="number" id="amount" name="amount" placeholder="Enter amount" min="1" step="1" required>
                    </div>
                </div>

                <div class="button">
                    <button type="submit" class="btn" name="dregister" id="dregister">Record Donation</button>
                    <a href="sponsors.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php if ($sponsor): ?>
<div class="container_admin">
    <div class="table_title">
        <h1>Contribution History</h1>
    </div>
    <hr>

    <?php if (empty($records)): ?>
        <div class="empty-state">
            <h3>No Contributions Recorded</h3>
            <p>Donations recorded for <?php echo e($sponsor['company']); ?> will appear here.</p>
        </div>
    <?php else: ?>
        <div class="details_table">
            <table id="table-2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Amount (Rs.)</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $row): ?>
                        <tr>
                            <td><strong><?php echo e($row['key_id']); ?></strong></td>
                            <td><span class="badge badge-neutral"><?php echo e($row['status']); ?></span></td>
                            <td>Rs. <?php echo number_format((int)$row['amount']); ?></td>
                            <td><?php echo e($row['date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>
