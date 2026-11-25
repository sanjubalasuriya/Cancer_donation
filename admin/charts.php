<?php
<<<<<<< HEAD
include __DIR__ . '/header.php';
=======
include('header.php');
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
?>

<div class="container_admin">
    <div class="table_title">
<<<<<<< HEAD
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
=======
        <h1>Charts</h1>


    </div>
    <hr>
    <div class="charts">
        <a href="d_chart.php" class="chart">
            <div>
                <h3>Donations</h3>
            </div>
        </a>

        <a href="p_chart.php" class="chart">
            <div>
                <h3>Patients</h3>
            </div>
        </a>

        <a href="c_chart.php" class="chart">
            <div>
                <h3>Cancers Prediction</h3>
            </div>
        </a>

    </div>

</div>



<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
