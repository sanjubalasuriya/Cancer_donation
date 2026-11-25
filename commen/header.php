<?php
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/security.php';

$currentPage = basename($_SERVER['PHP_SELF'] ?? 'index.php');
?>
<header class="header">
    <div class="header-inner">
        <a href="index.php" class="logo" aria-label="Save Life Cancer Foundation Home">
            <img src="img/logo2.png" alt="Save Life Logo">
        </a>

        <nav class="navbar" aria-label="Main navigation">
            <a href="index.php" class="a <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">Home</a>
            <a href="about.php" class="a <?php echo $currentPage === 'about.php' ? 'active' : ''; ?>">About</a>
            <a href="event.php" class="a <?php echo in_array($currentPage, ['event.php', 'events.php'], true) ? 'active' : ''; ?>">Events</a>
            <a href="news.php" class="a <?php echo in_array($currentPage, ['news.php', 'newss.php'], true) ? 'active' : ''; ?>">News</a>
            <a href="contact.php" class="a <?php echo $currentPage === 'contact.php' ? 'active' : ''; ?>">Contact</a>
            <a href="login.php" class="a <?php echo $currentPage === 'login.php' ? 'active' : ''; ?>">Portal Login</a>
            <a href="donate.php" class="btn nav_btn">Donate Now</a>
        </nav>

        <div class="icons">
            <button type="button" class="fas fa-bars" id="menu-btn" aria-label="Toggle navigation menu"></button>
        </div>
    </div>
</header>
<main class="page-main">
