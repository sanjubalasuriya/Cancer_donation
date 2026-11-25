<<<<<<< HEAD
<?php
require_once __DIR__ . '/helpers/security.php';
start_secure_session();

if (!empty($_SESSION['uname']) && !empty($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin/index.php');
        exit();
    }
    if ($_SESSION['role'] === 'salon') {
        header('Location: salon/index.php');
        exit();
    }
}

$statusMsg = $_SESSION['status'] ?? '';
unset($_SESSION['status']);
?>
<!DOCTYPE html>
<html lang="en">
=======
<!DOCTYPE html>
<html lang="en">

>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Portal Login | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <div class="auth-wrapper">
        <div class="login">
            <div class="auth-brand">
                <img src="img/logo2.png" alt="Save Life Logo">
                <h1>Portal Sign In</h1>
                <p>Admin &amp; Partner Salon Access</p>
            </div>

            <?php if ($statusMsg !== ''): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                    <span><?php echo e($statusMsg); ?></span>
                </div>
            <?php endif; ?>

            <form action="loginn.php" method="POST" novalidate>
                <?php echo csrf_field(); ?>
                <div class="auth-field">
                    <label for="uname">Username</label>
                    <input type="text" id="uname" name="uname" placeholder="Enter your username" required autocomplete="username">
                </div>
                <div class="auth-field">
                    <label for="password">Password</label>
                    <div class="password-wrap">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                        <button type="button" class="toggle-password" id="togglePassword" aria-label="Show or hide password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn" name="login_btn">Sign In</button>
            </form>

            <div class="auth-footer">
                <a href="index.php">&larr; Back to Save Life Home</a>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var btn = document.getElementById("togglePassword");
            var input = document.getElementById("password");
            if (btn && input) {
                btn.addEventListener("click", function () {
                    var isPassword = input.type === "password";
                    input.type = isPassword ? "text" : "password";
                    btn.innerHTML = isPassword ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
                });
            }
        })();
    </script>
</body>
</html>
=======
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
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
