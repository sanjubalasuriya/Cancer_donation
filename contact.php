<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="shotcut icon" href="img/Logo..png" type="x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="script.js">
    <title>Save Life</title>

    <link rel="stylesheet" href="index.css">
    <link rel="shotcut icon" href="img/logo.png" type="x-icon">
</head>

<body>
    <?php
    include('commen/header.php');

    ?>

    <section class="container map_container">
        <h1>Contact Us</h1>
        <iframe class="map"
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15845.776220661473!2d79.9203196!3d6.8372443!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x884f7e1e67a4d49b!2sApeksha%20Hospital%20Maharagama!5e0!3m2!1sen!2slk!4v1655892491289!5m2!1sen!2slk"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>

        <form action="">
    </section>

    <section class="container contact_container">
        <div class="contact_us">
            <h1>Contact Us</h1>
            <h3>For more information or queries, please contact:</h3>

            <div class="contact__options">
                <article class="contact__option icon">
                    <span class="fa fa-envelope"></span>
                    <h2>Email</h2>
                    <h5><a href="mailto:sanjubalasuriyar@gmail.com" target="_blank">
                            sanjubalasuriya@gmail.com
                        </a></h5>

                </article>

                <article class="contact__option">
                    <span class="fa fa-comment icon"></span>
                    <h2>Messenger</h2>
                    <h5><a href="https://www.facebook.com/ApekshaHospital.ncisl/" target="_blank">
                            Send a messege
                        </a></h5>

                </article>

                <article class="contact__option">
                    <span class="fas fa-map-marked-alt icon"></span>
                    <h2>Address</h2>
                    <h5><a href="https://www.google.com/maps/place/Apeksha+Hospital+Maharagama/@6.8372443,79.9203196,15z/data=!4m5!3m4!1s0x0:0x884f7e1e67a4d49b!8m2!3d6.8372443!4d79.9203196"
                            target="_blank">
                            Apeksha Hospital Maharagama - 10280
                        </a></h5>

                </article>
            </div>



        </div>
        <div class="contact_form">
            <h1 class="online">Online Enquiries</h1>

            <form action="">
                <input type="text" name="name" placeholder="Your Full Name" required />
                <input type="text" name="name" placeholder="Your Email" required />
                <textarea name="message" rows="7" placeholder="Your Messege" required></textarea>
                <button type="submit" class="btn btn-primary">
                    Send Message
                </button>
            </form>
        </div>

    </section>
    <div class="footer_margin">

    </div>


    <?php
include('commen/footer.php');
?>

    <script src="commen/script.js"></script>

</body>

</html>