<?php
<<<<<<< HEAD
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
=======
include('header.php');
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
?>

<div class="container_admin">
    <div class="table_title">
<<<<<<< HEAD
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
=======
        <h1>Patients Charts</h1>

    </div>
    <hr>

    <div class="table_subtitle">
        <h3>Patients Monthly increase<ion-icon name="calendar-outline"></ion-icon>
        </h3>
        <hr>
    </div>



    <?php

$res=mysqli_query($con,"SELECT MONTHNAME(date) as mname, COUNT(*) as row FROM patients GROUP BY MONTH(date)");
$amount = array();
$month = array();

                while($row=mysqli_fetch_array($res))
                {
                    
$amount[] = $row["row"];
$month[] = $row["mname"];

                }

?>
    <div class="patient_month">
        <canvas id="pmonth" height="120"></canvas>
    </div>


    <script>
    const amount = <?php echo json_encode($amount); ?>

    const data = {
        labels: <?php echo json_encode($month); ?>,
        datasets: [{
            label: <?php echo json_encode($month); ?>,
            data: amount,
            backgroundColor: [
                'rgba(190, 4, 4)',
                'rgba(190, 4, 4)',
                'rgba(190, 4, 4)',
                'rgba(190, 4, 4)',
                'rgba(190, 4, 4)',
                'rgba(190, 4, 4)',
            ],

            borderWidth: 1
        }]
    };


    const config = {
        type: 'bar',
        data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    const pmonth = new Chart(document.getElementById('pmonth'),
        config);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</div>



<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
