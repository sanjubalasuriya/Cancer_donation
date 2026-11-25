<?php
include __DIR__ . '/header.php';
$uname = $_SESSION['uname'] ?? '';
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Admin Profile</h1>
    </div>
    <hr>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo e($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="content_form">
        <form method="POST" action="pro.php">
            <?php echo csrf_field(); ?>
            <div class="input-details">
                <div class="input-box">
                    <label class="labels" for="uname">Username</label>
                    <input type="text" id="uname" name="uname" value="<?php echo e($uname); ?>" readonly>
                </div>
                <div class="input-box">
                    <label class="labels" for="password">Current Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter current password" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="npass">New Password</label>
                    <input type="password" id="npass" name="npass" placeholder="At least 6 characters" minlength="6" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="cpass">Confirm Password</label>
                    <input type="password" id="cpass" name="cpass" placeholder="Re-enter new password" minlength="6" required>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn" name="psubmit" id="psubmit">Update Password</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
