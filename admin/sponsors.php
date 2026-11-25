<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/admin_actions.php';

handle_admin_delete_request($con, 'sponsors', 'Sponsor');

include __DIR__ . '/header.php';

$sponsors = [];
$res = mysqli_query($con, 'SELECT `id`, `s_id`, `f_name`, `l_name`, `contact`, `email`, `company`, `image` FROM `sponsors` ORDER BY `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $sponsors[] = $row;
    }
}
$csrf = csrf_token();
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Sponsors</h1>
        <a href="sponsorReg.php" class="btn">Register Sponsor</a>
    </div>
    <hr>

    <div class="repot_table">
        <input type="text" id="searchBox-2" data-table-search="#table-2" placeholder="Search sponsors...">
        <form action="export.php" method="post">
            <?php echo csrf_field(); ?>
            <button name="sponsor_repo" type="submit" class="btn btn-secondary">
                <ion-icon class="report_icon" name="download-outline"></ion-icon>
                <span>Export Excel</span>
            </button>
        </form>
    </div>

    <?php if (empty($sponsors)): ?>
        <div class="empty-state">
            <h3>No Sponsors Registered</h3>
            <p>Add corporate or individual sponsors to recognize them on the homepage and track contributions.</p>
            <a href="sponsorReg.php" class="btn">Register Sponsor</a>
        </div>
    <?php else: ?>
        <div class="details_table">
            <table id="table-2">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>ID</th>
                        <th>Contact Person</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sponsors as $row): ?>
                        <tr>
                            <td>
                                <img class="table-thumb" src="../<?php echo e($row['image'] ?: 'img/logo.png'); ?>" alt="<?php echo e($row['company']); ?>">
                            </td>
                            <td><strong><?php echo e($row['s_id']); ?></strong></td>
                            <td><?php echo e($row['f_name'] . ' ' . $row['l_name']); ?></td>
                            <td><?php echo e($row['contact']); ?></td>
                            <td><?php echo e($row['email']); ?></td>
                            <td><?php echo e($row['company']); ?></td>
                            <td>
                                <div class="action-group">
                                    <a href="edit_sponsor.php?id=<?php echo (int)$row['id']; ?>" class="action edit">Edit</a>
                                    <a href="donate_sponsor.php?id=<?php echo (int)$row['id']; ?>" class="action secondary">Donate</a>
                                    <button type="button"
                                            class="action delete secondary js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Delete Sponsor?"
                                            data-text="This will remove <?php echo e($row['company']); ?> from sponsors."
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
