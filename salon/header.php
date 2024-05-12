<!-- header section starts  -->
<?php 
include('security.php');
include ('../db/db.php');
$uname = $_SESSION['uname'];
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../db/main.js"></script>
<script type="text/javascript">
function lettersOnly(input) {
    var regex = /[^a-z]/gi;
    input.value = input.value.replace(regex, "");
}
</script>
<header class="header">



    <a href="index.php" class="logo">
        <h1><?php echo $uname; ?></h1>
        <form action="logout.php" method="POST">
            <button type="submit" class="btn btn-primary" name="logout">Logout<span class="icon">
                    <ion-icon name="log-out-outline"></ion-icon>
                </span></button>
        </form>
    </a>

    <nav class="navbar">
        <a href="index.php" class="a">HOME</a>
        <a href="profile.php" class="a">PROFILE</a>

    </nav>


    <div class="icons">

        <div class="fas fa-bars" id="menu-btn"></div>
    </div>



</header>

<!-- header section ends -->