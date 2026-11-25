<?php
require_once __DIR__ . '/helpers/security.php';
start_secure_session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/commen/header.php'; ?>

    <section class="container map_container">
        <h1>Contact Us</h1>
        <h3>Reach out for donations, item drop-offs, or foundation enquiries</h3>
        <hr>
        <iframe class="map"
            title="Apeksha Hospital Maharagama Location"
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15845.776220661473!2d79.9203196!3d6.8372443!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x884f7e1e67a4d49b!2sApeksha%20Hospital%20Maharagama!5e0!3m2!1sen!2slk!4v1655892491289!5m2!1sen!2slk"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

    <section class="container contact_container">
        <div class="contact_us">
            <h2>Get in Touch</h2>
            <p style="color:var(--text-secondary);margin-top:0.35rem;">For more information or queries, reach us via any channel below:</p>

            <div class="contact__options">
                <article class="contact__option">
                    <span class="fa fa-envelope icon" aria-hidden="true"></span>
                    <div>
                        <h2>Email</h2>
                        <a href="mailto:sanjubalasuriya@gmail.com" target="_blank" rel="noopener noreferrer">sanjubalasuriya@gmail.com</a>
                    </div>
                </article>

                <article class="contact__option">
                    <span class="fa fa-comment icon" aria-hidden="true"></span>
                    <div>
                        <h2>Messenger</h2>
                        <a href="https://www.facebook.com/ApekshaHospital.ncisl/" target="_blank" rel="noopener noreferrer">Send a Facebook message</a>
                    </div>
                </article>

                <article class="contact__option">
                    <span class="fas fa-map-marked-alt icon" aria-hidden="true"></span>
                    <div>
                        <h2>Address</h2>
                        <a href="https://www.google.com/maps/place/Apeksha+Hospital+Maharagama/@6.8372443,79.9203196,15z/data=!4m5!3m4!1s0x0:0x884f7e1e67a4d49b!8m2!3d6.8372443!4d79.9203196"
                           target="_blank" rel="noopener noreferrer">
                            Apeksha Hospital, Maharagama - 10280
                        </a>
                    </div>
                </article>
            </div>
        </div>

        <div class="form-card" style="margin-top:0;">
            <h2 style="margin-bottom:1rem;">Online Enquiries</h2>
            <div id="contact_sign"></div>
            <form method="POST" action="contactSubmit.php" novalidate>
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="contact_name">Your Full Name</label>
                    <input type="text" id="contact_name" name="name" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="contact_email">Your Email</label>
                    <input type="email" id="contact_email" name="email" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label for="contact_message">Your Message</label>
                    <textarea id="contact_message" name="message" rows="5" placeholder="Write your enquiry here..." required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" id="contactSubmit" class="btn">Send Message</button>
                </div>
            </form>
        </div>
    </section>

    <?php include __DIR__ . '/commen/footer.php'; ?>
</body>
</html>
