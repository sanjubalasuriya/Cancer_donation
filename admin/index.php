<?php
include __DIR__ . '/header.php';

$patientCount = (int)mysqli_fetch_row(mysqli_query($con, 'SELECT COUNT(*) FROM `patients`'))[0];
$memberCount = (int)mysqli_fetch_row(mysqli_query($con, 'SELECT COUNT(*) FROM `members`'))[0];
$sponsorCount = (int)mysqli_fetch_row(mysqli_query($con, 'SELECT COUNT(*) FROM `sponsors`'))[0];
$dailyTotal = (float)(mysqli_fetch_row(mysqli_query($con, 'SELECT COALESCE(SUM(`amount`), 0) FROM `donations` WHERE DATE(`date`) = CURDATE()'))[0] ?? 0);

$chartLabels = [];
$chartTotals = [];
$res = mysqli_query($con, 'SELECT `status` AS st, COALESCE(SUM(`amount`), 0) AS total FROM `donations` GROUP BY `status` ORDER BY total DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $chartLabels[] = $row['st'];
        $chartTotals[] = (float)$row['total'];
    }
}
?>

<div class="cardBox">
    <div class="card">
        <a href="patients.php">
            <div>
                <div class="numbers"><?php echo number_format($patientCount); ?></div>
                <div class="cardName">Patients</div>
            </div>
            <div class="iconBx"><ion-icon name="person-outline"></ion-icon></div>
        </a>
    </div>

    <div class="card">
        <a href="members.php">
            <div>
                <div class="numbers"><?php echo number_format($memberCount); ?></div>
                <div class="cardName">Members</div>
            </div>
            <div class="iconBx"><ion-icon name="people-outline"></ion-icon></div>
        </a>
    </div>

    <div class="card">
        <a href="sponsors.php">
            <div>
                <div class="numbers"><?php echo number_format($sponsorCount); ?></div>
                <div class="cardName">Sponsors</div>
            </div>
            <div class="iconBx"><ion-icon name="business-outline"></ion-icon></div>
        </a>
    </div>

    <div class="card">
        <a href="donations.php">
            <div>
                <div class="numbers">Rs. <?php echo number_format($dailyTotal); ?></div>
                <div class="cardName">Today's Donations</div>
            </div>
            <div class="iconBx"><ion-icon name="cash-outline"></ion-icon></div>
        </a>
    </div>
</div>

<div class="dashboard-grid">
    <div class="quick-actions-grid">
        <a href="events.php" class="quick-card">
            <div>
                <h3>Manage Events</h3>
                <p>Add or edit foundation events</p>
            </div>
            <ion-icon name="calendar-outline" class="ion"></ion-icon>
        </a>

        <a href="newss.php" class="quick-card">
            <div>
                <h3>Manage News</h3>
                <p>Publish community stories</p>
            </div>
            <ion-icon name="newspaper-outline" class="ion"></ion-icon>
        </a>

        <a href="donations.php" class="quick-card">
            <div>
                <h3>All Donations</h3>
                <p>Review financial contributions</p>
            </div>
            <ion-icon name="cash-outline" class="ion"></ion-icon>
        </a>

        <a href="salons.php" class="quick-card">
            <div>
                <h3>Partner Salons</h3>
                <p>Manage map locations &amp; accounts</p>
            </div>
            <ion-icon name="location-outline" class="ion"></ion-icon>
        </a>

        <a href="organ_list.php" class="quick-card">
            <div>
                <h3>Hair Requests</h3>
                <p>Approve &amp; email certificates</p>
            </div>
            <ion-icon name="ribbon-outline" class="ion"></ion-icon>
        </a>

        <a href="reports.php" class="quick-card">
            <div>
                <h3>Excel Reports</h3>
                <p>Export filtered datasets</p>
            </div>
            <ion-icon name="download-outline" class="ion"></ion-icon>
        </a>
    </div>

    <div class="chart-card">
        <h3>Donations by Category (Rs.)</h3>
        <?php if (empty($chartLabels)): ?>
            <div class="empty-state">
                <h3>No Donation Data Yet</h3>
                <p>Donations recorded across patients, members, sponsors, and hospital projects will appear here.</p>
            </div>
        <?php else: ?>
            <div class="patient_month">
                <canvas id="pmonth"></canvas>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($chartLabels)): ?>
<script>
new Chart(document.getElementById("pmonth"), {
    type: "doughnut",
    data: {
        labels: <?php echo json_encode($chartLabels); ?>,
        datasets: [{
            label: "Total (Rs.)",
            data: <?php echo json_encode($chartTotals); ?>,
            backgroundColor: [
                "#b91c1c",
                "#e11d48",
                "#2563eb",
                "#059669",
                "#d97706",
                "#7c3aed",
                "#0891b2"
            ],
            borderWidth: 2,
            borderColor: "#ffffff"
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: "bottom" }
        }
    }
});
</script>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>
