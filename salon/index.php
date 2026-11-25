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
    <title>Hair Donation Registration | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="../img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/header.php'; ?>

    <section class="container donate_container">
        <h1>Hair Donation Registration</h1>
        <h3>Register a donor to request an official Save Life Foundation certificate</h3>
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
        <h1>Organ Donate</h1>
        <h3>Register here to get Certificate</h3>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
        <hr>
    </section>

    <section class="container">
<<<<<<< HEAD
        <div id="organ_sign"></div>

        <div class="form-card">
            <form method="POST" action="organReg.php" novalidate>
                <?php echo csrf_field(); ?>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="f_name">Donor First Name</label>
                        <input type="text" id="f_name" name="f_name" placeholder="First name" onkeyup="lettersOnly(this)" required>
                    </div>

                    <div class="form-group">
                        <label for="l_name">Donor Last Name</label>
                        <input type="text" id="l_name" name="l_name" placeholder="Last name" onkeyup="lettersOnly(this)" required>
                    </div>

                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" max="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="contact">Phone Number (10 digits)</label>
                        <input type="tel" id="contact" name="contact" placeholder="07XXXXXXXX" maxlength="10" pattern="[0-9]{10}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Donor Email Address</label>
                        <input type="email" id="email" name="email" placeholder="donor@example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select gender...</option>
=======

        <div class="" id="organ_sign">

        </div>

        <div class="container member_form">
            <form method="POST">
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Your First Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="" name="f_name" placeholder="Your name.." onkeyup="lettersOnly(this)">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Your Last Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="" name="l_name" placeholder="Your name.." onkeyup="lettersOnly(this)">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="fname">Date of Birth</label>
                    </div>
                    <div class="col-75">
                        <input type="date" id="" name="dob" placeholder="Your name..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Phone No</label>
                    </div>
                    <div class="col-75">
                        <input type="number" id="" name="contact" placeholder="Your Phone no..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Email</label>
                    </div>
                    <div class="col-75">
                        <input type="email" id="" name="email" placeholder="Your Email..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="lname">Gender</label>
                    </div>
                    <div class="col-75">

                        <select name="gender" id="">
                            <option value="">Select..</option>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
<<<<<<< HEAD

                    <div class="form-group full">
                        <label for="nic">NIC Number</label>
                        <input type="text" id="nic" name="nic" placeholder="e.g. 901711671V or 199017101671" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button class="btn" name="organ" id="organ" type="submit">Submit Certificate Request</button>
                </div>
            </form>
        </div>
    </section>

    <section class="container donate_container">
        <h2>Submitted Requests</h2>
        <h3>Recent hair donation certificate requests from <?php echo e($uname); ?></h3>
        <hr>

        <?php
        $requests = [];
        $reqStmt = mysqli_prepare($con, 'SELECT `id`, `f_name`, `l_name`, `email`, `nic`, `request`, `date` FROM `organ` WHERE `salon_id` = ? ORDER BY `id` DESC LIMIT 25');
        if ($reqStmt) {
            mysqli_stmt_bind_param($reqStmt, 's', $uname);
            mysqli_stmt_execute($reqStmt);
            $reqRes = mysqli_stmt_get_result($reqStmt);
            if ($reqRes) {
                while ($r = mysqli_fetch_assoc($reqRes)) {
                    $requests[] = $r;
                }
            }
            mysqli_stmt_close($reqStmt);
        }
        ?>

        <?php if (empty($requests)): ?>
            <div class="empty-state">
                <h3>No Submissions Yet</h3>
                <p>Certificate requests submitted by your salon will appear here with live approval status.</p>
            </div>
        <?php else: ?>
            <div class="details_table">
                <table>
                    <thead>
                        <tr>
                            <th>Donor Name</th>
                            <th>Email</th>
                            <th>NIC</th>
                            <th>Status</th>
                            <th>Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $req): ?>
                            <tr>
                                <td><strong><?php echo e($req['f_name'] . ' ' . $req['l_name']); ?></strong></td>
                                <td><?php echo e($req['email']); ?></td>
                                <td><?php echo e($req['nic']); ?></td>
                                <td>
                                    <span class="badge <?php echo $req['request'] === 'sent' ? 'badge-success' : 'badge-warning'; ?>">
                                        <?php echo e($req['request']); ?>
                                    </span>
                                </td>
                                <td><?php echo e($req['date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>

    <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
=======
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="lname">NIC</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="" name="nic" placeholder="Amount of your donation">
                    </div>
                </div>

                <br>
                <div class="row transfer">
                    <button class="btn" name="organ" id="organ" type="submit">Submit</button>
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
