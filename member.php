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
    <title>Membership | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/commen/header.php'; ?>

    <section class="container donate_container">
        <h1>Be a Member</h1>
        <h3>Join Save Life Cancer Foundation with a 1-year annual membership (Rs. 1,000)</h3>
        <hr>
    </section>

    <section class="container">
        <div id="member_sign"></div>

        <div class="form-card">
            <form method="POST" action="memberReg.php" novalidate>
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
                        <label for="nic">NIC Number</label>
                        <input type="text" id="nic" name="nic" placeholder="e.g. 901711671V or 199017101671" required>
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
                        <label for="amount">Membership Fee (Rs.)</label>
                        <input type="number" id="amount" name="amount" value="1000" readonly>
                    </div>
                </div>

                <div class="form-actions">
                    <button class="btn" name="msubmit" id="msubmit" type="submit">Register Membership</button>
                </div>
            </form>
        </div>
    </section>

    <section class="container donate_container">
        <h1>Renew Membership</h1>
        <h3>Already registered? Renew your Save Life Foundation membership for another year</h3>
        <hr>
    </section>

    <section class="container">
        <div id="member_sign1"></div>

        <div class="form-card">
            <form method="POST" action="memberReg2.php" novalidate>
                <?php echo csrf_field(); ?>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nic1">Registered NIC Number</label>
                        <input type="text" id="nic1" name="nic1" placeholder="Enter your registered NIC" required>
                    </div>

                    <div class="form-group">
                        <label for="email1">Registered Email Address</label>
                        <input type="email" id="email1" name="email1" placeholder="you@example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="amount1">Renewal Fee (Rs.)</label>
                        <input type="number" id="amount1" name="amount1" value="1000" readonly>
                    </div>
                </div>

                <div class="form-actions">
                    <button class="btn" name="msubmit1" id="msubmit1" type="submit">Renew Membership</button>
                    <a href="donate.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </section>

    <?php include __DIR__ . '/commen/footer.php'; ?>
</body>
</html>
