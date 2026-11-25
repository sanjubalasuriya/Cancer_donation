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
        <hr>
    </section>

    <section class="container">
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
