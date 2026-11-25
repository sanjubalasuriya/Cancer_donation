<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/admin_actions.php';

handle_admin_delete_request($con, 'cancers', 'Cancer type');

include __DIR__ . '/header.php';

$cancers = [];
$res = mysqli_query($con, 'SELECT `id`, `num`, `name` FROM `cancers` ORDER BY `id` ASC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $cancers[] = $row;
    }
}
$csrf = csrf_token();
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Cancer Types</h1>
        <a href="cancerReg.php" class="btn">Add Cancer Type</a>
    </div>
    <hr>

    <?php if (empty($cancers)): ?>
        <div class="empty-state">
            <h3>No Cancer Categories Added</h3>
            <p>Add cancer types so they appear in patient registration and reporting filters.</p>
            <a href="cancerReg.php" class="btn">Add Cancer Type</a>
        </div>
    <?php else: ?>
        <div class="details_table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Cancer Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cancers as $row): ?>
                        <tr>
                            <td>#<?php echo (int)$row['id']; ?></td>
                            <td><strong><?php echo e($row['num']); ?></strong></td>
                            <td><?php echo e($row['name']); ?></td>
                            <td>
                                <div class="action-group">
                                    <a href="edit_cancer.php?id=<?php echo (int)$row['id']; ?>" class="action edit">Edit</a>
                                    <button type="button"
                                            class="action delete secondary js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Delete Cancer Type?"
                                            data-text="This will remove <?php echo e($row['name']); ?>."
                                            data-confirm-text="Delete">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
