<?php
include __DIR__ . '/header.php';

$months = [];
$counts = [];
$res = mysqli_query($con, 'SELECT MONTH(date) AS mnum, ANY_VALUE(MONTHNAME(date)) AS mname, COUNT(*) AS row_count FROM `patients` GROUP BY MONTH(date) ORDER BY mnum ASC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $months[] = $row['mname'];
        $counts[] = (int)$row['row_count'];
    }
}
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Patient Registration Trends</h1>
        <a href="charts.php" class="btn btn-secondary">Back to Charts</a>
    </div>
    <hr>

    <?php if (empty($months)): ?>
        <div class="empty-state">
            <h3>No Patient Records Yet</h3>
            <p>Monthly registration trends will appear once patients are registered.</p>
        </div>
    <?php else: ?>
        <div class="chart-card">
            <h3>Monthly Patient Registrations</h3>
            <div class="patient_month">
                <canvas id="pmonth"></canvas>
            </div>
        </div>

        <script>
        new Chart(document.getElementById("pmonth"), {
            type: "bar",
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: "Registered Patients",
                    data: <?php echo json_encode($counts); ?>,
                    backgroundColor: "rgba(185, 28, 28, 0.85)",
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
        </script>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
