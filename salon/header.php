<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/security.php';

$uname = $_SESSION['uname'] ?? '';
$currentSalonPage = basename($_SERVER['PHP_SELF'] ?? 'index.php');

$salonTitle = $uname;
$stmt = mysqli_prepare($con, 'SELECT `name` FROM `salons` WHERE `s_id` = ? LIMIT 1');
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $uname);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res && ($row = mysqli_fetch_assoc($res))) {
        $salonTitle = $row['name'] . ' (' . $uname . ')';
    }
    mysqli_stmt_close($stmt);
}
?>
<header class="header">
    <div class="header-inner">
        <div class="salon-brand-wrap">
            <a href="index.php" class="logo">
                <img src="logo2.png" alt="Save Life Logo">
            </a>
            <span class="salon-badge"><?php echo e($salonTitle); ?></span>
        </div>

        <nav class="navbar" aria-label="Salon navigation">
            <a href="index.php" class="a <?php echo $currentSalonPage === 'index.php' ? 'active' : ''; ?>">Hair Donation</a>
            <a href="profile.php" class="a <?php echo $currentSalonPage === 'profile.php' ? 'active' : ''; ?>">Profile</a>
            <form action="logout.php" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-sm" name="logout">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <span>Logout</span>
                </button>
            </form>
        </nav>

        <div class="icons">
            <button type="button" class="fas fa-bars" id="menu-btn" aria-label="Toggle navigation menu"></button>
        </div>
    </div>
</header>
<main class="page-main">
