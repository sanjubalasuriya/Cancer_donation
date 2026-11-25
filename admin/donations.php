<?php
include __DIR__ . '/header.php';

$donations = [];
$res = mysqli_query($con, 'SELECT `id`, `key_id`, `amount`, `status`, `date` FROM `donations` ORDER BY `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $donations[] = $row;
    }
}
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Donations</h1>
    </div>
    <hr>

    <div class="repot_table">
        <input type="text" id="searchDonations" data-table-search="#donationsTable" placeholder="Search by key, category, or date...">
    </div>

    <?php if (empty($donations)): ?>
        <div class="empty-state">
            <h3>No Donations Recorded</h3>
            <p>All member, patient, sponsor, and hospital donations will appear here.</p>
        </div>
    <?php else: ?>
        <div class="details_table">
            <table id="donationsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Reference Key</th>
                        <th>Amount (Rs.)</th>
                        <th>Category</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donations as $row): ?>
                        <tr>
                            <td>#<?php echo (int)$row['id']; ?></td>
                            <td><strong><?php echo e($row['key_id']); ?></strong></td>
                            <td>Rs. <?php echo number_format((int)$row['amount']); ?></td>
                            <td><span class="badge badge-neutral"><?php echo e($row['status']); ?></span></td>
                            <td><?php echo e($row['date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
