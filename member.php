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
    <link rel="shotcut icon" href="img/logo.png" type="x-icon">


</head>

<body>


    <?php
include('commen/header.php');
?>



    <section class="container donate_container">
        <h1>Be a Member</h1>
        <h3>Be a member in Cancer Foundation</h3>
        <hr>
    </section>

    <section class="container">
        <div class="" id="member_sign">

        </div>
        <div class="" id="member_sign1">

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
                        <label>Your Last Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="l_name" placeholder="Your name.." onkeyup="lettersOnly(this)">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label>NIC No</label>
                    </div>
                    <div class="col-75">
                        <input type="text" i name="nic" placeholder="Your NIC no..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label>Phone No</label>
                    </div>
                    <div class="col-75">
                        <input type="number" name="contact" placeholder="Your Phone no..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label>Email</label>
                    </div>
                    <div class="col-75">
                        <input type="email" name="email" placeholder="Your Email..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label>Amount (Rs)</label>
                    </div>
                    <div class="col-75">
                        <input type="number" name="amount" placeholder="Amount of your donation" value="1000" readonly>
                    </div>
                </div>

                <br>
                <div class="row transfer">
                    <button class="btn" name="msubmit" id="msubmit" type="submit">Be a Member</button>

                </div>
            </form>
        </div>

    </section>


    <section class="container donate_container">
        <h1>Renew Membership</h1>
        <h3>You can renew your membership in Cancer Foundation</h3>
        <hr>
    </section>

    <section class="container">
        <div class="" id="member_sign">

        </div>



        <div class="container member_form">
            <form method="POST">

                <div class="row">
                    <div class="col-25">
                        <label>NIC No</label>
                    </div>
                    <div class="col-75">
                        <input type="text" i name="nic1" placeholder="Your NIC no..">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label>Email</label>
                    </div>
                    <div class="col-75">
                        <input type="email" name="email1" placeholder="Your Email..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label>Amount (Rs)</label>
                    </div>
                    <div class="col-75">
                        <input type="number" name="amount1" placeholder="Amount of your donation" value="1000" readonly>
                    </div>
                </div>

                <br>
                <div class="row transfer">
                    <button class="btn" name="msubmit1" id="msubmit1" type="submit">Be a Member</button>

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