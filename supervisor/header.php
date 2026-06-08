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

    <title>Supervisor Dashboard</title>

    <link rel="stylesheet"
          href="../assets/css/supervisor.css?v=<?php echo time(); ?>">

</head>

<body>

<div class="dashboard-container">
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">
            <h2>Supervisor panel</h2>
        </div>
        <ul>
            <li> <a href="dashboard.php"> Dashboard </a></li>
            <li> <a href="view-logs.php">Student Logs </a></li>
            <li> <a href="view-evidence.php"> Weekly Evidence </a> </li>
            <li> <a href="student.php">Assigned Students</a></li>
            <li><a href="student-progress.php"> Progress Monitor</a> </li>
            <li> <a href="messages.php">  Messages </a></li>
            <li><a href="../auth/logout.php"> Logout</a></li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->

    <div class="main-content">