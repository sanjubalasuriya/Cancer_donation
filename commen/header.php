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