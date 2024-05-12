<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <hr>
    </section>

    <section class="container">

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
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
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