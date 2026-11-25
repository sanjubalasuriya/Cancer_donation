<?php
include __DIR__ . '/header.php';

$months = [];
$totals = [];
$res = mysqli_query($con, 'SELECT MONTH(date) AS mnum, ANY_VALUE(MONTHNAME(date)) AS mname, COALESCE(SUM(amount), 0) AS total FROM `donations` GROUP BY MONTH(date) ORDER BY mnum ASC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $months[] = $row['mname'];
        $totals[] = (float)$row['total'];
    }
}

$catLabels = [];
$catTotals = [];
$res2 = mysqli_query($con, 'SELECT `status`, COALESCE(SUM(amount), 0) AS total FROM `donations` GROUP BY `status` ORDER BY total DESC');
if ($res2) {
    while ($row = mysqli_fetch_assoc($res2)) {
        $catLabels[] = $row['status'];
        $catTotals[] = (float)$row['total'];
    }
}
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Donations Analytics</h1>
        <a href="charts.php" class="btn btn-secondary">Back to Charts</a>
    </div>
    <hr>

    <?php if (empty($months)): ?>
        <div class="empty-state">
            <h3>No Donation Records Yet</h3>
            <p>Charts will populate once donations are recorded.</p>
        </div>
    <?php else: ?>
        <div class="dashboard-grid">
            <div class="chart-card">
                <h3>Monthly Donations (Rs.)</h3>
                <div class="patient_month">
                    <canvas id="donation"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h3>By Donation Category (Rs.)</h3>
                <div class="patient_month">
                    <canvas id="donation1"></canvas>
                </div>
            </div>
        </div>

        <script>
        new Chart(document.getElementById("donation"), {
            type: "bar",
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: "Monthly Donations (Rs.)",
                    data: <?php echo json_encode($totals); ?>,
                    backgroundColor: "rgba(185, 28, 28, 0.85)",
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });

        new Chart(document.getElementById("donation1"), {
            type: "doughnut",
            data: {
                labels: <?php echo json_encode($catLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($catTotals); ?>,
                    backgroundColor: ["#b91c1c", "#2563eb", "#059669", "#d97706", "#7c3aed", "#0891b2"]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: "bottom" } }
            }
        });
        </script>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
