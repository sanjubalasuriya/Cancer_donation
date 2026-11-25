<?php
<<<<<<< HEAD
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
=======

include('header.php');
?>



<div class="cardBox">
    <div class="card"><a href="patients.php">
            <div>

                <?php 

            $query = "SELECT id FROM patients ORDER BY id";
            $Query_run = mysqli_query($con, $query);

            $row = mysqli_num_rows($Query_run);

            echo '<div class="numbers">'.$row.'</div>'

            ?>

                <div class="cardName">Patients</div>
            </div>
            <div class="iconBx">
                <ion-icon name="person-outline"></ion-icon>
            </div>
        </a>
    </div>

    <div class="card"><a href="members.php">
            <div>
                <?php 

            $query = "SELECT id FROM members ORDER BY id";
            $Query_run = mysqli_query($con, $query);

            $row = mysqli_num_rows($Query_run);

            echo '<div class="numbers">'.$row.'</div>'


            ?>
                <div class="cardName">Members</div>
            </div>
            <div class="iconBx">
                <ion-icon name="people-outline"></ion-icon>
            </div>
        </a>
    </div>

    <div class="card"><a href="sponsors.php">
            <div>
                <?php 

            $query = "SELECT id FROM sponsors ORDER BY id";
            $Query_run = mysqli_query($con, $query);

            $row = mysqli_num_rows($Query_run);

            echo '<div class="numbers">'.$row.'</div>'


            ?>
                <div class="cardName">Sponsors</div>
            </div>
            <div class="iconBx">
                <ion-icon name="people-outline"></ion-icon>
            </div>
        </a>
    </div>

    <div class="card"><a href="donations.php">
            <div>
                <?php 

            $res=mysqli_query($con,"SELECT sum(amount) as total FROM donations WHERE DATE(date)=CURDATE() ");
         while($row=mysqli_fetch_array($res))
         {
            ?>
                <div class="numbers"><?php echo number_format($row["total"]) ?></div>
                <?php 
         }

            ?>
                <div class="cardName">Daily Donations (Rs.)</div>
            </div>
            <div class="iconBx">
                <ion-icon name="cash-outline"></ion-icon>
            </div>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
        </a>
    </div>
</div>

<<<<<<< HEAD
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
=======
<div class="cardbox2">
    <a href="events.php">
        <div class="event">
            <h1>Add Events</h1>
            <ion-icon name="pricetags-outline" class="ion"></ion-icon>
        </div>
    </a>

    <a href="newss.php">
        <div class="news">
            <h1>Add News</h1>
            <ion-icon name="newspaper-outline" class="ion"></ion-icon>
        </div>
    </a>
</div>

<div class="cardbox2">
    <a href="donations.php">
        <div class="event">
            <h1>Donations</h1>
            <ion-icon name="cash-outline" class="ion"></ion-icon>
        </div>
    </a>

    <a href="salons.php">
        <div class="news">
            <h1>Add Saloon Locations</h1>
            <ion-icon name="location-outline" class="ion"></ion-icon>
        </div>
    </a>

</div>

<div class="cardbox2">
    <a href="organ_list.php">
        <div class="event">
            <h1>Hair Donate List</h1>
            <ion-icon name="list-outline" class="ion"></ion-icon>
        </div>
    </a>

    <?php

$res=mysqli_query($con,"SELECT status as st, sum(amount) as total FROM donations GROUP BY status ");
$amount = array();
$month = array();

                while($row=mysqli_fetch_array($res))
                {
                    
$amount[] = $row["total"];
$month[] = $row["st"];
// $status[] = $row["status"];

                }

?>
    <div class="index_chart">
        <div class="patient_month">
            <canvas id="pmonth" height="120"></canvas>
        </div>
    </div>




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
            'rgba(235, 232, 0)',
            'rgba(255, 99, 132)',
            'rgba(54, 162, 235)',
            'rgba(99, 255, 166)',
            'rgba(255, 205, 86)',
            'rgba(178, 117, 255)',
        ],

        borderWidth: 1
    }]
};


const config = {
    type: 'doughnut',
    data,
    options: {
        scales: {

        }
    }
};

const pmonth = new Chart(document.getElementById('pmonth'),
    config);
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
