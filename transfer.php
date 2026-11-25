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
    <title>Donate to Patient | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php
    include __DIR__ . '/commen/header.php';

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $patient = null;
    if ($id && $id > 0) {
        $stmt = mysqli_prepare($con, 'SELECT `id`, `p_id`, `f_name`, `l_name`, `cancer`, `c_step`, `amount`, `donate`, `image` FROM `patients` WHERE `id` = ? LIMIT 1');
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $patient = $res ? mysqli_fetch_assoc($res) : null;
            mysqli_stmt_close($stmt);
        }
    }
    ?>

    <?php if (!$patient): ?>
        <section class="container donate_container">
            <div class="empty-state">
                <h3>Patient Record Not Found</h3>
                <p>Please select a registered high-risk patient from the patients list to make a donation.</p>
                <a href="money.php" class="btn">View Patients</a>
            </div>
        </section>
    <?php else:
        $needed = max(1, (int)$patient['amount']);
        $received = max(0, (int)$patient['donate']);
        $remaining = max(0, $needed - $received);
        $pct = min(100, (int)round(($received / $needed) * 100));
    ?>
        <section class="container donate_container">
            <h1>Donate to <?php echo e($patient['f_name'] . ' ' . $patient['l_name']); ?></h1>
            <h3>Support urgent treatment for <?php echo e($patient['cancer']); ?></h3>
            <hr>
        </section>

        <section class="container">
            <article class="news" style="margin-bottom:1.5rem;">
                <div class="news_img">
                    <img src="<?php echo e($patient['image'] ?: 'img/patients1.jpg'); ?>" alt="<?php echo e($patient['f_name']); ?>">
                </div>
                <div class="news_des">
                    <div class="news_description">
                        <h3>Patient ID: <?php echo e($patient['p_id']); ?></h3>
                        <p>Treatment for <strong><?php echo e($patient['cancer']); ?></strong><?php echo !empty($patient['c_step']) ? ' (' . e($patient['c_step']) . ')' : ''; ?></p>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: <?php echo $pct; ?>%;"></div>
                    </div>
                    <div class="funding-meta">
                        <span>Goal: <strong>Rs. <?php echo number_format($needed); ?></strong></span>
                        <span>Raised: <strong>Rs. <?php echo number_format($received); ?></strong></span>
                        <span>Remaining: <strong>Rs. <?php echo number_format($remaining); ?></strong></span>
                    </div>
                </div>
            </article>

            <div id="transfer_sign"></div>

            <div class="form-card">
                <form method="POST" action="transferReg.php" novalidate>
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="iid" value="<?php echo (int)$patient['id']; ?>">
                    <input type="hidden" name="p_id" value="<?php echo e($patient['p_id']); ?>">

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="f_name">Your First Name</label>
                            <input type="text" id="f_name" name="f_name" placeholder="Your first name" onkeyup="lettersOnly(this)" required>
                        </div>

                        <div class="form-group">
                            <label for="l_name">Your Last Name</label>
                            <input type="text" id="l_name" name="l_name" placeholder="Your last name" onkeyup="lettersOnly(this)" required>
                        </div>

                        <div class="form-group">
                            <label for="contact">Phone Number (10 digits)</label>
                            <input type="tel" id="contact" name="contact" placeholder="07XXXXXXXX" maxlength="10" pattern="[0-9]{10}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="you@example.com" required>
                        </div>

                        <div class="form-group full">
                            <label for="amount">Donation Amount (Rs.)</label>
                            <input type="number" id="amount" name="amount" placeholder="Enter amount in Rs." min="1" step="1" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="btn" name="transfer" id="transfer" type="submit">Complete Donation</button>
                        <a href="money.php" class="btn btn-secondary">Back to Patients</a>
                    </div>
                </form>
            </div>
        </section>
    <?php endif; ?>

    <?php include __DIR__ . '/commen/footer.php'; ?>
</body>
</html>
