<?php
<<<<<<< HEAD
include __DIR__ . '/header.php';
$uname = $_SESSION['uname'] ?? '';
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Admin Profile</h1>
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

    <div class="content_form">
        <form method="POST" action="pro.php">
            <?php echo csrf_field(); ?>
            <div class="input-details">
                <div class="input-box">
                    <label class="labels" for="uname">Username</label>
                    <input type="text" id="uname" name="uname" value="<?php echo e($uname); ?>" readonly>
                </div>
                <div class="input-box">
                    <label class="labels" for="password">Current Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter current password" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="npass">New Password</label>
                    <input type="password" id="npass" name="npass" placeholder="At least 6 characters" minlength="6" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="cpass">Confirm Password</label>
                    <input type="password" id="cpass" name="cpass" placeholder="Re-enter new password" minlength="6" required>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn" name="psubmit" id="psubmit">Update Password</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
=======

include('header.php');
$uname = $_SESSION['uname'];


?>




<div class="container_admin">
    <div class="table_title">
        <h1>Profile</h1>


    </div>
    <hr>
    <div class="" id="csign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Password Changed Successfully!
    </div>

    <div class="">
        <?php
                if(isset($_SESSION['error'])){
                    echo"
                    <div class='alert alert-warning text-center'>
                    
                    ".$_SESSION['error']."
                    </div>
                    ";
                    unset($_SESSION['error']);
                }

                if(isset($_SESSION['success'])){
                    echo"
                    <div class='alert alert-success text-center'>
                    
                    ".$_SESSION['success']."
                    </div>
                    ";
                    unset($_SESSION['success']);

                }
                ?>

        <div class="content_form">
            <form method="POST" action="pro.php">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">User Name</label>
                        <input type="text" placeholder="Enter First name" required name="uname"
                            value="<?php echo $uname;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Currunt Password</label>
                        <input type="text" placeholder="Enter Currunt Password" required name="password">
                    </div>
                    <div class="input-box">
                        <label class="labels">New Password</label>
                        <input type="text" placeholder="Enter New Password" required name="npass">
                    </div>
                    <div class="input-box">
                        <label class="labels">Confirm Password</label>
                        <input type="text" placeholder="Enter Confirm Password" required name="cpass">
                    </div>

                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Register" name="psubmit" id="psubmit">
                </div>
            </form>
        </div>

    </div>

</div>



<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
