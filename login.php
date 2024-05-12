<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<?php
session_start();

?>

<body>
    <div class="container">
        <div class="login">
            <h1>Welcome</h1>
            <?php
              
              if(isset($_SESSION['status']) && $_SESSION['status'] !='')
                   {
                      echo '<div class="text-center"><p class="bg-danger text-white"> '.$_SESSION['status'].' </p></div>';
                      unset($_SESSION['status']);
                    }
                              
                              ?>
            <form action="loginn.php" method="POST">
                <div class="txt_field">
                    <input type="text" name="uname" required autocomplete="off">
                    <span></span>
                    <label for="">Username</label>
                </div>
                <div class="txt_field">
                    <input type="password" name="password" required>
                    <span></span>
                    <label for="">Password</label>
                </div>
                <!-- <a class="pass" href="">Fogot password..?</a> -->
                <br>
                <button type="submit" class="btn" name="login_btn">Login</button>
            </form>
        </div>
    </div>

</body>

</html>