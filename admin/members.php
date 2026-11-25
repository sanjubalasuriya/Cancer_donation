<?php
include __DIR__ . '/header.php';

$members = [];
$res = mysqli_query($con, 'SELECT `m_id`, `f_name`, `l_name`, `contact`, `email`, `nic`, `status`, `date` FROM `members` ORDER BY `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $members[] = $row;
    }
}
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Members</h1>
    </div>
    <hr>

    <div class="repot_table">
        <input type="text" id="searchBox-2" data-table-search="#table-2" placeholder="Search members...">
        <form action="export.php" method="post">
            <?php echo csrf_field(); ?>
            <button name="members_repo" type="submit" class="btn btn-secondary">
                <ion-icon class="report_icon" name="download-outline"></ion-icon>
                <span>Export Excel</span>
            </button>
        </form>
    </div>

    <?php if (empty($members)): ?>
        <div class="empty-state">
            <h3>No Members Registered Yet</h3>
            <p>Members who register via the public portal will appear here.</p>
        </div>
    <?php else: ?>
        <div class="details_table">
            <table id="table-2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>NIC</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $row): ?>
                        <tr>
                            <td><strong><?php echo e($row['m_id']); ?></strong></td>
                            <td><?php echo e($row['f_name'] . ' ' . $row['l_name']); ?></td>
                            <td><?php echo e($row['nic']); ?></td>
                            <td><?php echo e($row['contact']); ?></td>
                            <td><?php echo e($row['email']); ?></td>
                            <td>
                                <span class="badge <?php echo strtolower((string)$row['status']) === 'paid' ? 'badge-success' : 'badge-neutral'; ?>">
                                    <?php echo e($row['status']); ?>
                                </span>
                            </td>
                            <td><?php echo e($row['date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
