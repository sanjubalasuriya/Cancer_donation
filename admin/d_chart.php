<?php
<<<<<<< HEAD
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
=======
include('header.php');
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
?>

<div class="container_admin">
    <div class="table_title">
<<<<<<< HEAD
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
=======
        <h1>Donations Charts</h1>


    </div>
    <hr>

    <div class="table_subtitle">
        <h3>Monthly Grow<ion-icon name="calendar-outline"></ion-icon>
        </h3>
        <hr>
    </div>




    <?php





$res=mysqli_query($con,"SELECT MONTHNAME(date) as mname, sum(amount) as total FROM donations GROUP BY MONTH(date)");
$amount = array();
$month = array();

                while($row=mysqli_fetch_array($res))
                {
                    
$amount[] = $row["total"];
$month[] = $row["mname"];

                }



                // ========================================

                $res=mysqli_query($con,"SELECT MONTHNAME(date) as mname1, COUNT(*) as row FROM patients GROUP BY MONTH(date)");
$amount1 = array();
$month1 = array();

                while($row=mysqli_fetch_array($res))
                {
                    
$amount1[] = $row["row"];
$month1[] = $row["mname1"];

                }


?>




    <div class="patient_month">

        <canvas id="donation"></canvas>

    </div>

    <!-- <div class="patient_month">

        <canvas id="donation1"></canvas>

    </div> -->


    <script>
    const amount = <?php echo json_encode($amount); ?>



    const data = {
        labels: <?php echo json_encode($month); ?>,
        datasets: [{
            label: <?php echo json_encode($month); ?>,
            data: amount,
            backgroundColor: [
                'rgba(190, 4, 4)',

            ],

            borderWidth: 1
        }]
    };


    const config = {
        type: 'bar',
        data,
        options: {
            responsive: true,
        }
    };



    const donation = new Chart(document.getElementById('donation'),
        config);


    //======================================================================================

    const amount1 = <?php echo json_encode($amount1); ?>

    const data1 = {
        labels: <?php echo json_encode($month1); ?>,
        datasets: [{
            label: '# of Votes',
            data: amount1,
            backgroundColor: [
                'rgba(190, 4, 4)',
            ],

            borderWidth: 1
        }]
    };

    const config1 = {
        type: 'bar',
        data: data1,
        options: {
            responsive: true,
        }
    };

    const donation1 = new Chart(document.getElementById('donation1'),
        config1);
    </script>



</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
