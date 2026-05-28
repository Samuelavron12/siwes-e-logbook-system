<?php
require_once 'header.php';
require_once '../config/db.php';

/* TOTAL STUDENTS */

$students =
$conn->query("
    SELECT COUNT(*) AS total
    FROM users
    WHERE role = 'student'
")->fetch_assoc()['total'];

/* TOTAL SUPERVISORS */

$supervisors =
$conn->query("
    SELECT COUNT(*) AS total
    FROM users
    WHERE role = 'supervisor'
")->fetch_assoc()['total'];

/* TOTAL LOGS */

$logs =
$conn->query("
    SELECT COUNT(*) AS total
    FROM log_entries
")->fetch_assoc()['total'];

/* APPROVED LOGS */

$approved =
$conn->query("
    SELECT COUNT(*) AS total
    FROM log_entries
    WHERE status = 'approved'
")->fetch_assoc()['total'];
?>

<!-- PAGE HEADER -->

<div class="page-header">

    <h1>
        Welcome, <?php echo $_SESSION['full_name']; ?>
    </h1>

    <p>
        SIWES E-Logbook Management Dashboard
    </p>

</div>

<!-- CARDS -->

<div class="cards">

    <div class="card">

        <h3>Total Students</h3>

        <p><?php echo $students; ?></p>

    </div>

    <div class="card">

        <h3>Total Supervisors</h3>

        <p><?php echo $supervisors; ?></p>

    </div>

    <div class="card">

        <h3>Total Logs</h3>

        <p><?php echo $logs; ?></p>

    </div>

    <div class="card">

        <h3>Approved Logs</h3>

        <p><?php echo $approved; ?></p>

    </div>

</div>

<?php
require_once 'footer.php';
?>