<?php
<<<<<<< HEAD
include __DIR__ . '/header.php';

$cancerOptions = [];
$res = mysqli_query($con, 'SELECT `name` FROM `cancers` ORDER BY `name` ASC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $cancerOptions[] = $row['name'];
    }
}
=======
include('header.php');
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
?>

<div class="container_admin">
    <div class="table_title">
<<<<<<< HEAD
        <h1>Excel Reports</h1>
    </div>
    <hr>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo e($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="table_subtitle">
        <h3><ion-icon name="person-outline"></ion-icon> Patients by Cancer Type</h3>
        <div class="content_form">
            <form action="export.php" method="post">
                <?php echo csrf_field(); ?>
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels" for="cancer">Cancer Type</label>
                        <select id="cancer" name="cancer" required>
                            <option value="">Select cancer type...</option>
                            <?php foreach ($cancerOptions as $cname): ?>
                                <option value="<?php echo e($cname); ?>"><?php echo e($cname); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="button">
                    <button name="report_pa" type="submit" class="btn">
                        <ion-icon name="download-outline"></ion-icon>
                        <span>Export Filtered Patients (.xlsx)</span>
=======
        <h1>Reports</h1>

    </div>
    <hr>
    <?php
                if(isset($_SESSION['error'])){
                    echo"
                    <div class='alert alert-danger'>
                    <h4>error!</h4>
                    ".$_SESSION['error']."
                    </div>
                    ";
                    unset($_SESSION['error']);
                }

                if(isset($_SESSION['success'])){
                    echo"
                    <div class='alert alert-success'>
                    <h4>Success!</h4>
                    ".$_SESSION['success']."
                    </div>
                    ";
                    unset($_SESSION['success']);

                }
                ?>
    <div class="table_subtitle">
        <h3>Patients Filter Data sheet<ion-icon name="calendar-outline"></ion-icon>
        </h3>
        <hr>



        <div class="content_form">
            <form action="export.php" method="post">
                <div class="input-details">
                    <div class="input-box">
                        <?php 
                
                $sql = "SELECT * FROM `cancers` ";
                $res = mysqli_query($con, $sql);

               
            
                ?>
                        <label class="labels">Cancer</label>
                        <select name="cancer" id="" required>
                            <option value="">Select</option>
                            <?php while($rows = mysqli_fetch_array($res)){
                            ?>
                            <option value="<?php echo $rows['name']; ?>"><?php echo $rows['name'] ?></option>
                            <?php

                            }?>
                        </select>
                    </div>

                </div>

                <div class="button">


                    <button name="report_pa" type="submit" class="btn ">
                        Export <ion-icon class="report_icon" name="document-outline"></ion-icon>
                        <ion-icon class="report_pa" name="download-outline">
                        </ion-icon>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
                    </button>
                </div>
            </form>
        </div>
<<<<<<< HEAD
    </div>

    <hr style="margin:2rem 0;">

    <div class="table_subtitle">
        <h3><ion-icon name="cash-outline"></ion-icon> Donations by Category</h3>
        <div class="content_form">
            <form action="export.php" method="post">
                <?php echo csrf_field(); ?>
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels" for="status">Donation Category</label>
                        <select id="status" name="status" required>
                            <option value="all">All Donations</option>
                            <option value="member">Members</option>
                            <option value="patients">Patients</option>
                            <option value="sponsor">Sponsors</option>
                            <option value="New Hospital Building">New Hospital Building</option>
                            <option value="Pet Scan Machine">PET Scan Machine</option>
                        </select>
                    </div>
                </div>
                <div class="button">
                    <button name="report_do" type="submit" class="btn">
                        <ion-icon name="download-outline"></ion-icon>
                        <span>Export Donations (.xlsx)</span>
=======


    </div>

    <!-- <div class="table_subtitle">
        <h3>Donation Filter Data sheet<ion-icon name="calendar-outline"></ion-icon>
        </h3>
        <hr>



        <div class="content_form">
            <form action="export.php" method="post">
                <div class="input-details">
                    <div class="input-box">

                        <label class="labels">Cancer</label>
                        <select name="status" id="" >
                            <option value="">Select</option>
                            <option value="member">Members</option>
                            <option value="patients">Patients</option>
                            <option value="sponsor">Sponsor</option>
                            <option value="New Hospital Building">New Hospital Building</option>
                            <option value="Pet Sacn Machine">Pet Scan Machine</option>



                        </select>
                    </div>

                </div>

                <div class="button">


                    <button name="report_do" type="submit" class="btn ">
                        Export <ion-icon class="report_icon" name="document-outline"></ion-icon>
                        <ion-icon class="report_do" name="download-outline">
                        </ion-icon>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
                    </button>
                </div>
            </form>
        </div>
<<<<<<< HEAD
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
=======


    </div> -->

    <!-- <div class="table_subtitle">
        <h3>Monthly Grow<ion-icon name="calendar-outline"></ion-icon>
        </h3>
        <hr>



        <div class="content_form">
            <form action="export.php" method="post">
                <div class="input-details">
                    <div class="input-box">
                        <?php 
                
                $sql = "SELECT * FROM `cancers` ";
                $res = mysqli_query($con, $sql);

               
            
                ?>
                        <label class="labels">Cancer</label>
                        <select name="cancer" id="">
                            <option value="">Select</option>
                            <?php while($rows = mysqli_fetch_array($res)){
                            ?>
                            <option value="<?php echo $rows['name']; ?>"><?php echo $rows['name'] ?></option>
                            <?php

                            }?>
                        </select>
                    </div>

                </div>

                <div class="button">


                    <button name="" type="submit" class="btn ">
                        Export <ion-icon class="report_icon" name="document-outline"></ion-icon>
                        <ion-icon class="report_icon" name="download-outline">
                        </ion-icon>
                    </button>
                </div>
            </form>
        </div>


    </div> -->



</div>



<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
