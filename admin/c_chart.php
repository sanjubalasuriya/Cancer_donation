<?php
include __DIR__ . '/header.php';

$cancerLabels = [];
$cancerCounts = [];
$res = mysqli_query($con, 'SELECT `cancer`, COUNT(*) AS total FROM `patients` GROUP BY `cancer` ORDER BY total DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $cancerLabels[] = $row['cancer'];
        $cancerCounts[] = (int)$row['total'];
    }
}

$stageLabels = [];
$stageCounts = [];
$res2 = mysqli_query($con, 'SELECT `c_step`, COUNT(*) AS total FROM `patients` GROUP BY `c_step` ORDER BY `c_step` ASC');
if ($res2) {
    while ($row = mysqli_fetch_assoc($res2)) {
        $stageLabels[] = $row['c_step'];
        $stageCounts[] = (int)$row['total'];
    }
}
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Cancer Type &amp; Stage Breakdown</h1>
        <a href="charts.php" class="btn btn-secondary">Back to Charts</a>
    </div>
    <hr>

    <?php if (empty($cancerLabels)): ?>
        <div class="empty-state">
            <h3>No Patient Data Available</h3>
            <p>Register patients to visualize cancer type and stage distribution.</p>
        </div>
    <?php else: ?>
        <div class="dashboard-grid">
            <div class="chart-card">
                <h3>Patients by Cancer Type</h3>
                <div class="patient_month">
                    <canvas id="cancerTypeChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h3>Patients by Stage</h3>
                <div class="patient_month">
                    <canvas id="cancerStageChart"></canvas>
                </div>
            </div>
        </div>

        <script>
        new Chart(document.getElementById("cancerTypeChart"), {
            type: "bar",
            data: {
                labels: <?php echo json_encode($cancerLabels); ?>,
                datasets: [{
                    label: "Patients",
                    data: <?php echo json_encode($cancerCounts); ?>,
                    backgroundColor: "rgba(185, 28, 28, 0.85)",
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });

        new Chart(document.getElementById("cancerStageChart"), {
            type: "pie",
            data: {
                labels: <?php echo json_encode($stageLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($stageCounts); ?>,
                    backgroundColor: ["#059669", "#2563eb", "#d97706", "#b91c1c"]
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
