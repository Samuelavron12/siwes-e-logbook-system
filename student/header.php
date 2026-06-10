<?php

session_start();

require_once '../config/db.php';

if(isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];

    mysqli_query(

        $conn,

        "

        UPDATE users

        SET last_login = NOW()

        WHERE user_id='$user_id'

        "

    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet"href="../assets/css/student.css?v=<?php echo time(); ?>">
</head>
<body>
    <!-- MOBILE NAVBAR -->

    <div class="mobile-navbar">
        <!-- LOGO -->
        <div class="mobile-logo">
            SIWES System
        </div>
        <!-- HAMBURGER -->
        <div class="menu-toggle" id="menuToggle">
            ☰
        </div>
    </div>
    <div class="dashboard-container">
        <!-- SIDEBAR -->
        <div class="sidebar" id="sidebar">
            <div class="logo">
                <h2>student panel</h2>
            </div>
            <ul>
                <li><a href="../student/dashboard.php">Dashboard</a></li>
                <li><a href="../student/profile.php">Profile</a></li>
                <li><a href="supervisor.php">  Supervisor Information </a></li>
                <li><a href="../student/add-log.php">Add Log Entry</a></li>
                <li><a href="../student/view-logs.php">View Logs</a></li>
                <li><a href="../student/weekly-evidence.php">Weekly Evidence</a></li>
                <li><a href="weekly-evidence-list.php">My Evidence</a></li>
                <li> <a href="progress.php">Progress </a></li>
                <li> <a href="evaluation.php"> Evaluation Results   </a></li>
                <li><a href="../student/report.php">Reports</a></li>
                <li><a href="messages.php"> Messages</a>
                <li><a href="../student/notifications.php">Notifications</a></li>
                <li><a href="announcements.php">Announcements</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
               
</li>
            </ul>
        </div>
        <!-- MAIN CONTENT -->
        <div class="main-content">


