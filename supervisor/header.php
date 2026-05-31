<?php
require_once '../config/config.php';
require_once '../includes/auth.php';

if($_SESSION['role'] != 'supervisor'){

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

    <title>Supervisor Dashboard</title>

    <link rel="stylesheet"
          href="../assets/css/supervisor.css?v=<?php echo time(); ?>">

</head>

<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="logo">

            <h2>Supervisor</h2>

        </div>

        <ul>

            <li>
                <a href="dashboard.php">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="view-logs.php">
                    Student Logs
                </a>
            </li>

            <li>
                <a href="../auth/logout.php">
                    Logout
                </a>
            </li>
            <li>
                <a href="view-evidence.php">
                    Weekly Evidence
                </a>
            </li>

        </ul>

    </div>

    <!-- MAIN CONTENT -->

    <div class="main-content">