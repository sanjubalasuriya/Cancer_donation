<?php
<<<<<<< HEAD
include __DIR__ . '/header.php';

$donations = [];
$res = mysqli_query($con, 'SELECT `id`, `key_id`, `amount`, `status`, `date` FROM `donations` ORDER BY `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $donations[] = $row;
    }
}
=======
include('header.php');

>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Donations</h1>
<<<<<<< HEAD
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
=======


    </div>
    <hr>

    <!-- <div class="charts">
        <a href="d_chart.php" class="chart">
            <div>
                <h3>Membership Donations</h3>
            </div>
        </a>

        <a href="p_chart.php" class="chart">
            <div>
                <h3>Hospital Donations</h3>
            </div>
        </a>

        <a href="c_chart.php" class="chart">
            <div>
                <h3>Patients Donations</h3>
            </div>
        </a>

    </div> -->

    <div class="container_body">
        <div class="details_table">


            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Key</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>

                    </tr>
                </thead>
                <?php 
                $res=mysqli_query($con,"SELECT * FROM `donations`");
                while($row=mysqli_fetch_array($res))
                {
                ?>

                <tbody>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>

                        <td><?php echo $row["key_id"]; ?></td>
                        <td><?php echo number_format($row["amount"]) ?></td>
                        <td><?php echo $row["status"]; ?></td>
                        <td><?php echo $row["date"]; ?></td>

                    </tr>

                </tbody>

                <?php 
                }
                ?>

            </table>

        </div>

    </div>

</div>



<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
