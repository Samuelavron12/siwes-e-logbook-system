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

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link rel="stylesheet"
          href="../assets/css/admin.css?v=<?php echo time(); ?>">

</head>

<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="logo">

            <h2>ADMIN PANEL</h2>

        </div>

        <ul>

            <li>
                <a href="dashboard.php">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="students.php">
                    Students
                </a>
            </li>

            <li>
                <a href="supervisors.php">
                    Supervisors
                </a>
            </li>

            <li>
                <a href="logs.php">
                    All Logs
                </a>
            </li>
            <li>
                <a href="assign-supervisor.php">
                    Assign Supervisor
                </a>
            </li>

            <li>
                <a href="../auth/logout.php">
                    Logout
                </a>
            </li>

        </ul>

    </div>

    <!-- MAIN CONTENT -->

    <div class="main-content">