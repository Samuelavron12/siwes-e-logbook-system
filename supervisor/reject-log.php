<?php
require_once '../config/db.php';
require_once '../config/notification.php';

if(isset($_GET['id'])){

    $id = $_GET['id'];

    /* REJECT LOG */

    mysqli_query(

        $conn,

        "

        UPDATE log_entries

        SET status = 'rejected'

        WHERE id = '$id'

        "
    );

    /* GET STUDENT ID */

    $student_query = mysqli_query(

        $conn,

        "

        SELECT student_id

        FROM log_entries

        WHERE id = '$id'

        "
    );

    $student = mysqli_fetch_assoc($student_query);

    /* CREATE NOTIFICATION */

    createNotification(

        $conn,

        $student['student_id'],

        'Your log entry was rejected.'
    );

    header("Location: view-logs.php");
    exit();
}
?>