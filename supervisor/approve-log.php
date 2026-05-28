<?php
require_once '../config/db.php';
require_once '../config/notification.php';

if(isset($_GET['id'])){

    $log_id = $_GET['id'];

    /* APPROVE */

   /* $conn->query("
        UPDATE log_entries
        SET status = 'approved'
        WHERE log_id = '$log_id'
    ");
*/
    $conn->query("
    UPDATE log_entries
    SET status = 'approved'
    WHERE id = '$id'
    ");
    /* GET STUDENT */

    $get = $conn->query("
        SELECT student_id
        FROM log_entries
        WHERE id = '$id'
    ");

    $row = $get->fetch_assoc();

    /* CREATE NOTIFICATION */

    createNotification(

        $conn,

        $row['student_id'],

        'Your log entry was approved.',

        'approval'
    );

    header("Location: view-logs.php");
    exit();
}
?>