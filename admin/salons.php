<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/admin_actions.php';

handle_admin_delete_request($con, 'salons', 'Salon');

include __DIR__ . '/header.php';

$salons = [];
$res = mysqli_query($con, 'SELECT `id`, `s_id`, `name`, `address`, `contact`, `email` FROM `salons` ORDER BY `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $salons[] = $row;
    }
}
$csrf = csrf_token();
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Partner Salons</h1>
        <a href="salon.php" class="btn">Register Salon</a>
    </div>
    <hr>

    <?php if (empty($salons)): ?>
        <div class="empty-state">
            <h3>No Partner Salons Registered</h3>
            <p>Add hair-donation partner salons so donors can locate them on the map.</p>
            <a href="salon.php" class="btn">Register Salon</a>
        </div>
    <?php else: ?>
        <div class="details_table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Salon Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salons as $row): ?>
                        <tr>
                            <td><strong><?php echo e($row['s_id']); ?></strong></td>
                            <td><?php echo e($row['name']); ?></td>
                            <td><?php echo e($row['address']); ?></td>
                            <td><?php echo e($row['contact']); ?></td>
                            <td><?php echo e($row['email']); ?></td>
                            <td>
                                <div class="action-group">
                                    <a href="edit_salon.php?id=<?php echo (int)$row['id']; ?>" class="action edit">Edit</a>
                                    <button type="button"
                                            class="action delete secondary js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Delete Salon?"
                                            data-text="This will also remove the salon's portal login account."
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
