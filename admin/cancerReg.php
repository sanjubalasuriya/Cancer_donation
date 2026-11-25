<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/id_generator.php';

$m_id = generate_next_id($con, 'cancers', 'num', 'C');

include __DIR__ . '/header.php';
=======
include('header.php');
include ('../db/db.php');
?>

<script src="../db/main.js"></script>

<?php 

$sql_id = "SELECT * FROM `cancers` order by id desc limit 1";
$res = mysqli_query($con, $sql_id);
 $row = mysqli_fetch_array($res);
 $lastid = $row['num'];

 if($lastid == " "){
   $m_id = "C1";
 }else{
   $m_id = substr($lastid,1);
   $m_id = intval($m_id);
   $m_id = "C" . ($m_id + 1);
 }


>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
?>

<div class="container_admin">
    <div class="table_title">
<<<<<<< HEAD
        <h1>Register Cancer Type</h1>
        <a href="cancers.php" class="btn btn-secondary">Back to Cancers</a>
    </div>
    <hr>

    <div id="csign"></div>

    <div class="content_form">
        <form method="POST" action="cregister.php">
            <?php echo csrf_field(); ?>
            <div class="input-details">
                <div class="input-box">
                    <label class="labels" for="num">Cancer Code</label>
                    <input type="text" id="num" name="num" value="<?php echo e($m_id); ?>" readonly>
                </div>
                <div class="input-box">
                    <label class="labels" for="name">Cancer Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter cancer name" required>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn" name="cregister" id="cregister">Save Cancer Type</button>
                <a href="cancers.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>

<script src="../db/main.js"></script>
<?php include __DIR__ . '/footer.php'; ?>
=======
        <h1>Cancer Register</h1>


    </div>
    <hr>
    <div class="" id="csign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Cancer Registerd Successfully!
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels"> ID</label>
                        <input type="text" placeholder="" required name="num" value="<?php echo $m_id;?>" readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels"> Name</label>
                        <input type="text" placeholder="Enter Cancer name" required name="name">
                    </div>
                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Register" name="cregister" id="cregister">
                    <a href="cancers.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>




<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
