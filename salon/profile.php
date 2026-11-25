<<<<<<< HEAD
<?php require_once __DIR__ . '/security.php'; ?>
<!DOCTYPE html>
<html lang="en">
=======
<!DOCTYPE html>
<html lang="en">

>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Salon Profile | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="../img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/header.php'; ?>

    <section class="container donate_container">
        <h1>Salon Profile</h1>
        <h3>Update your partner account password</h3>
=======
    <title>Save Life</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="index.css">
    <link rel="shotcut icon" href="../img/logo.png" type="x-icon">


</head>

<body>


    <?php
include('header.php');
?>

    <section class="container donate_container">
        <h1>Profile</h1>
        <h3>Change Password</h3>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
        <hr>
    </section>

    <section class="container">
<<<<<<< HEAD
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

        <div class="form-card">
            <form action="pro.php" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="uname">Salon Username</label>
                        <input type="text" id="uname" name="uname" value="<?php echo e($uname); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="password">Current Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter current password" required>
                    </div>

                    <div class="form-group">
                        <label for="npass">New Password</label>
                        <input type="password" id="npass" name="npass" placeholder="At least 6 characters" minlength="6" required>
                    </div>

                    <div class="form-group">
                        <label for="cpass">Confirm New Password</label>
                        <input type="password" id="cpass" name="cpass" placeholder="Re-enter new password" minlength="6" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button class="btn" name="psubmit" id="psubmit" type="submit">Update Password</button>
                    <a href="index.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </section>

    <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
=======

        <div class="" id="organ_sign">

        </div>
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

        <div class="container member_form">
            <form action="pro.php" method="post">
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Username</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="" name="uname" value="<?php echo $uname; ?>" placeholder="Your name.."
                            readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Currunt Password</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="" name="password" placeholder="Your name..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">New Password</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="" name="npass" placeholder="Your name..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="lname">Confirm Password</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="" name="cpass" placeholder="Amount of your donation">
                    </div>
                </div>

                <br>
                <div class="row transfer">
                    <button class="btn" name="psubmit" id="psubmit" type="submit">Change Password</button>
                </div>
            </form>
        </div>

    </section>
    <div class="footer_margin">

    </div>








    <?php
include('footer.php');
?>
    <!-- custom js file link  -->
    <script src="../commen/script.js"></script>

</body>

</html>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
