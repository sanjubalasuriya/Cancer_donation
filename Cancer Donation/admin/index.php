<?php

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
        </a>
    </div>
</div>

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