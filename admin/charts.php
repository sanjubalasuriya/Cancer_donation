<?php
include __DIR__ . '/header.php';
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Analytics &amp; Charts</h1>
    </div>
    <hr>

    <div class="charts">
        <a href="d_chart.php" class="chart">
            <h3>Donations Growth</h3>
            <p>Monthly donation revenue trends</p>
        </a>

        <a href="p_chart.php" class="chart">
            <h3>Patient Registrations</h3>
            <p>Monthly registered patient volume</p>
        </a>

        <a href="c_chart.php" class="chart">
            <h3>Cancer Breakdown</h3>
            <p>Distribution across cancer types and stages</p>
        </a>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
