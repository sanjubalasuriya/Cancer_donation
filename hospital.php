<<<<<<< HEAD
<?php
require_once __DIR__ . '/helpers/security.php';
start_secure_session();
?>
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
    <title>Donate to Hospital | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/commen/header.php'; ?>

    <section class="container donate_container">
        <h1>Donate to Hospital</h1>
        <h3>Support Save Life Cancer Foundation infrastructure and diagnostic equipment</h3>
=======
    <title>Save Life</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="index.css">
    <link rel="shotcut icon" href="img/logo.png" type="x-icon">


</head>

<body>


    <?php
include('commen/header.php');
?>

    <section class="container donate_container">
        <h1>Donate Hospital</h1>
        <h3>Donate hospital in Cancer Foundation</h3>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
        <hr>
    </section>

    <section class="container">
<<<<<<< HEAD
        <div id="hospital_sign"></div>

        <div class="form-card">
            <form method="POST" action="hospitaldonate.php" novalidate>
                <?php echo csrf_field(); ?>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="f_name">First Name</label>
                        <input type="text" id="f_name" name="f_name" placeholder="Your first name" onkeyup="lettersOnly(this)" required>
                    </div>

                    <div class="form-group">
                        <label for="l_name">Last Name</label>
                        <input type="text" id="l_name" name="l_name" placeholder="Your last name" onkeyup="lettersOnly(this)" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Donate For</label>
                        <select id="status" name="status" required>
                            <option value="">Select project...</option>
                            <option value="New Hospital Building">New Hospital Building</option>
                            <option value="Pet Scan Machine">PET Scan Machine</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contact">Phone Number (10 digits)</label>
                        <input type="tel" id="contact" name="contact" placeholder="07XXXXXXXX" maxlength="10" pattern="[0-9]{10}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="you@example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="amount">Donation Amount (Rs.)</label>
                        <input type="number" id="amount" name="amount" placeholder="e.g. 5000" min="1" step="1" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button class="btn" name="hospitalsubmit" id="hospitalsubmit" type="submit">Submit Donation</button>
                    <a href="donate.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </section>

    <?php include __DIR__ . '/commen/footer.php'; ?>
</body>
</html>
=======

        <div class="" id="hospital_sign">

        </div>

        <div class="container member_form">
            <form method="POST">
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Your First Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="f_name" name="f_name" placeholder="Your name.."
                            onkeyup="lettersOnly(this)">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Your Last Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="l_name" name="l_name" placeholder="Your name.."
                            onkeyup="lettersOnly(this)">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="fname">Donate for</label>
                    </div>
                    <div class="col-75">

                        <select name="status" id="" name="status">
                            <option value="" class="input_option">Select...</option>
                            <option value="New Hospital Building" class="input_option">New Hospital Building</option>
                            <option value="Pet Sacn Machine" class="input_option">Pet Sacn Machine</option>

                        </select>
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
                        <label for="lname">Amount</label>
                    </div>
                    <div class="col-75">
                        <input type="number" id="" name="amount" placeholder="Amount of your donation">
                    </div>
                </div>




                <br>
                <div class="row transfer">
                    <button class="btn" name="hospitalsubmit" id="hospitalsubmit" type="submit">Submit</button>
                </div>
            </form>
        </div>

    </section>
    <div class="footer_margin">

    </div>








    <?php
include('commen/footer.php');
?>
    <!-- custom js file link  -->
    <script src="commen/script.js"></script>

</body>

</html>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
