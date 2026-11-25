<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/admin_actions.php';

handle_admin_delete_request($con, 'event', 'Event');

include __DIR__ . '/header.php';

$events = [];
$res = mysqli_query($con, 'SELECT `id`, `title`, `location`, `image`, `description`, `date` FROM `event` ORDER BY `date` DESC, `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $events[] = $row;
    }
}
$csrf = csrf_token();
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Events</h1>
        <a href="event.php" class="btn">Add Event</a>
    </div>
    <hr>

    <?php if (empty($events)): ?>
        <div class="empty-state">
            <h3>No Events Created</h3>
            <p>Create awareness or fundraising events to display on the public website.</p>
            <a href="event.php" class="btn">Add Event</a>
        </div>
    <?php else: ?>
        <div class="details_table">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $row): ?>
                        <tr>
                            <td><img class="table-thumb" src="../<?php echo e($row['image']); ?>" alt="<?php echo e($row['title']); ?>"></td>
                            <td><strong><?php echo e($row['title']); ?></strong></td>
                            <td><?php echo e(mb_strimwidth((string)$row['description'], 0, 90, '...')); ?></td>
                            <td><?php echo e($row['location']); ?></td>
                            <td><?php echo e($row['date']); ?></td>
                            <td>
                                <div class="action-group">
                                    <a href="edit_event.php?id=<?php echo (int)$row['id']; ?>" class="action edit">Edit</a>
                                    <button type="button"
                                            class="action delete secondary js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Delete Event?"
                                            data-text="This will permanently delete <?php echo e($row['title']); ?>."
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
