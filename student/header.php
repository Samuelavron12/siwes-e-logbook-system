<?php
require_once '../config/config.php';
require_once '../includes/auth.php';

if($_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Student Dashboard</title>

    <link rel="stylesheet"
          href="../assets/css/student.css?v=<?php echo time(); ?>">

</head>
<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="logo">
            <h2>SIWES</h2>
        </div>

        <ul>

            <li><a href="../student/dashboard.php">Dashboard</a></li>
            <li><a href="../student/add-log.php">Add Log Entry</a></li>
            <li><a href="../student/view-logs.php">View Logs</a></li>
            <li><a href="../student/weekly-evidence.php">Weekly Evidence</a></li>
            <li><a href="../student/reports.php">Reports</a></li>
            <li><a href="../student/notifications.php">Notifications</a></li>
            <li><a href="../student/profile.php">Profile</a></li>
            <li><a href="../auth/logout.php">Logout</a></li>

        </ul>

    </div>

    <!-- MAIN CONTENT -->

    <div class="main-content">