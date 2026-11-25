<<<<<<< HEAD
<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/security.php';

$currentAdminPage = basename($_SERVER['PHP_SELF'] ?? 'index.php');
$adminUser = $_SESSION['uname'] ?? 'Admin';

function is_admin_active(string $current, array $pages): string
{
    return in_array($current, $pages, true) ? 'active-nav' : '';
}
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
    <title>Admin Dashboard | Save Life</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="../img/logo.png" type="image/png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    function lettersOnly(input) {
        if (!input) return;
        input.value = input.value.replace(/[^a-zA-Z\s]/g, "");
    }
    </script>
</head>
<body>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    <div class="admin-shell">
        <aside class="navigation" id="adminSidebar" aria-label="Admin navigation">
            <ul>
                <li class="brand-item">
                    <a href="index.php">
                        <span class="icon"><ion-icon name="heart-circle-outline"></ion-icon></span>
                        <span class="title">Save Life Admin</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['index.php']); ?>">
                    <a href="index.php">
                        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['patients.php', 'patientsReg.php', 'edit_patient.php']); ?>">
                    <a href="patients.php">
                        <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                        <span class="title">Patients</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['members.php']); ?>">
                    <a href="members.php">
                        <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                        <span class="title">Members</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['sponsors.php', 'sponsorReg.php', 'edit_sponsor.php', 'donate_sponsor.php']); ?>">
                    <a href="sponsors.php">
                        <span class="icon"><ion-icon name="business-outline"></ion-icon></span>
                        <span class="title">Sponsors</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['donations.php']); ?>">
                    <a href="donations.php">
                        <span class="icon"><ion-icon name="cash-outline"></ion-icon></span>
                        <span class="title">Donations</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['cancers.php', 'cancerReg.php', 'edit_cancer.php']); ?>">
                    <a href="cancers.php">
                        <span class="icon"><ion-icon name="medkit-outline"></ion-icon></span>
                        <span class="title">Cancers</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['events.php', 'event.php', 'edit_event.php']); ?>">
                    <a href="events.php">
                        <span class="icon"><ion-icon name="calendar-outline"></ion-icon></span>
                        <span class="title">Events</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['newss.php', 'news.php', 'edit_news.php']); ?>">
                    <a href="newss.php">
                        <span class="icon"><ion-icon name="newspaper-outline"></ion-icon></span>
                        <span class="title">News</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['salons.php', 'salon.php', 'edit_salon.php']); ?>">
                    <a href="salons.php">
                        <span class="icon"><ion-icon name="location-outline"></ion-icon></span>
                        <span class="title">Salons</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['organ_list.php']); ?>">
                    <a href="organ_list.php">
                        <span class="icon"><ion-icon name="ribbon-outline"></ion-icon></span>
                        <span class="title">Hair Requests</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['charts.php', 'd_chart.php', 'p_chart.php', 'c_chart.php']); ?>">
                    <a href="charts.php">
                        <span class="icon"><ion-icon name="stats-chart-outline"></ion-icon></span>
                        <span class="title">Charts</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['reports.php']); ?>">
                    <a href="reports.php">
                        <span class="icon"><ion-icon name="document-text-outline"></ion-icon></span>
                        <span class="title">Reports</span>
                    </a>
                </li>
                <li class="<?php echo is_admin_active($currentAdminPage, ['settings.php']); ?>">
                    <a href="settings.php">
                        <span class="icon"><ion-icon name="settings-outline"></ion-icon></span>
                        <span class="title">Profile</span>
                    </a>
                </li>
            </ul>
        </aside>

        <div class="main" id="adminMain">
            <header class="topbar">
                <div class="topbar-left">
                    <button type="button" class="toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                        <ion-icon name="menu-outline"></ion-icon>
                    </button>
                    <a href="../index.php" class="btn btn-secondary btn-sm" target="_blank" rel="noopener noreferrer">View Public Site</a>
                </div>
                <div class="topbar-right">
                    <span class="user-pill">
                        <ion-icon name="person-circle-outline"></ion-icon>
                        <?php echo e($adminUser); ?>
                    </span>
                    <form action="logout.php" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sm" name="logout">
                            <ion-icon name="log-out-outline"></ion-icon>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <main class="admin-content">
=======
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
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
