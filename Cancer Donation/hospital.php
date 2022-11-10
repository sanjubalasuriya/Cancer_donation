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
        <h1>Donate Hospital</h1>
        <h3>Donate hospital in Cancer Foundation</h3>
        <hr>
    </section>

    <section class="container">

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