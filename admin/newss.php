<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/admin_actions.php';

handle_admin_delete_request($con, 'news', 'News article');

include __DIR__ . '/header.php';

$newsList = [];
$res = mysqli_query($con, 'SELECT `id`, `title`, `image`, `description`, `date` FROM `news` ORDER BY `date` DESC, `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $newsList[] = $row;
    }
}
$csrf = csrf_token();
?>

<div class="container_admin">
    <div class="table_title">
        <h1>News</h1>
        <a href="news.php" class="btn">Add News</a>
    </div>
    <hr>

    <?php if (empty($newsList)): ?>
        <div class="empty-state">
            <h3>No News Articles</h3>
            <p>Publish foundation news and updates for visitors.</p>
            <a href="news.php" class="btn">Add News</a>
        </div>
    <?php else: ?>
        <div class="details_table">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Summary</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newsList as $row): ?>
                        <tr>
                            <td><img class="table-thumb" src="../<?php echo e($row['image']); ?>" alt="<?php echo e($row['title']); ?>"></td>
                            <td><strong><?php echo e($row['title']); ?></strong></td>
                            <td><?php echo e(mb_strimwidth((string)$row['description'], 0, 90, '...')); ?></td>
                            <td><?php echo e($row['date']); ?></td>
                            <td>
                                <div class="action-group">
                                    <a href="edit_news.php?id=<?php echo (int)$row['id']; ?>" class="action edit">Edit</a>
                                    <button type="button"
                                            class="action delete secondary js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Delete News Article?"
                                            data-text="This will remove <?php echo e($row['title']); ?>."
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
