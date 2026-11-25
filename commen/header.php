<<<<<<< HEAD
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
=======
<!-- header section starts  -->
<?php 

include ('db/db.php');

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="db/main.js"></script>
<script type="text/javascript">
function lettersOnly(input) {
    var regex = /[^a-z]/gi;
    input.value = input.value.replace(regex, "");
}
</script>
<header class="header">

    <a href="index.php" class="logo">

        <img src="img/logo2.png" alt="">
    </a>


    <nav class="navbar">

        <a href="donate.php" class=" btn nav_btn">Donate</a>
        <a href="index.php" class="a">HOME</a>
        <a href="about.php" class="a">ABOUT</a>
        <a href="contact.php" class="a">CONTACT</a>
        <a href="event.php" class="a">EVENT</a>
        <a href="news.php" class="a">NEWS</a>

    </nav>


    <div class="icons">

        <div class="fas fa-bars" id="menu-btn"></div>
    </div>



</header>

<!-- header section ends -->
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
