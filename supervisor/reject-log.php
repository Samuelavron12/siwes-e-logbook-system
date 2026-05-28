<?php
require_once '../config/db.php';
require_once '../config/notification.php';

$log_id = $_GET['log_id'] ?? null;

if (!$log_id) {
    die("Log ID not provided");
}

/* UPDATE STATUS */
$update = $conn->query("
    UPDATE log_entries 
    SET status = 'rejected'
    WHERE log_id = '$log_id'
");

/* GET STUDENT */
$get = $conn->query("
    SELECT student_id 
    FROM log_entries 
    WHERE log_id = '$log_id'
");

$row = $get->fetch_assoc();

if (!$row) {
    die("Log not found or invalid log_id");
}

/* CREATE NOTIFICATION */
createNotification(
    $conn,
    $row['student_id'],
    'Your log entry was rejected.',
    'rejection'
);

header("Location: view-logs.php");
exit();
?>