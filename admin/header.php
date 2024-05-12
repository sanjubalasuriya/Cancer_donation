<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shotcut icon" href="../img/logo.png" type="x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
    function lettersOnly(input) {
        var regex = /[^a-z]/gi;
        input.value = input.value.replace(regex, "");
    }
    </script>

</head>

<body>
    <?php
include('security.php');
include('../db/db.php');
?>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon"></span>
                        <span class="title">Cancer Hospital</span>
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="patients.php">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Patients</span>
                    </a>
                </li>
                <li>
                    <a href="members.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Members</span>
                    </a>
                </li>
                <li>
                    <a href="sponsors.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Sponsors</span>
                    </a>
                </li>
                <li>
                    <a href="cancers.php">
                        <span class="icon">
                            <ion-icon name="heart-outline"></ion-icon>
                        </span>
                        <span class="title">Cancers</span>
                    </a>
                </li>
                <li>
                    <a href="charts.php">
                        <span class="icon">
                            <ion-icon name="stats-chart-outline"></ion-icon>
                        </span>
                        <span class="title">Charts</span>
                    </a>
                </li>

                <li>
                    <a href="reports.php">
                        <span class="icon">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Reports</span>
                    </a>
                </li>
                <li>
                    <a href="settings.php">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Profile</span>
                    </a>
                </li>




            </ul>
        </div>


        <!-- main -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <!-- <div class="search">
                    <label for="">
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div> -->

                <div class="">
                    <form action="logout.php" method="POST">
                        <button type="submit" class="btn btn-primary" name="logout">Logout<span class="icon">
                                <ion-icon name="log-out-outline"></ion-icon>
                            </span></button>
                    </form>

                </div>


            </div>