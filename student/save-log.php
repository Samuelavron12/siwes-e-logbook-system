<?php
require_once '../config/db.php';
session_start();

if(isset($_POST['save_log'])){

    $student_id = $_SESSION['user_id'];
    $log_date = $_POST['log_date'];
    $title = $_POST['title'];
    $activity = $_POST['activity'];

    $file_name = null;

    /* HANDLE FILE UPLOAD */

    if(!empty($_FILES['attachment']['name'])){

        $file_name = time() . "_" .
        $_FILES['attachment']['name'];

        $tmp = $_FILES['attachment']['tmp_name'];

        move_uploaded_file(
            $tmp,
            "../uploads/" . $file_name
        );
    }

    $stmt = $conn->prepare("
        INSERT INTO log_entries
        (student_id, log_date, title, activity, attachment)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "issss",
        $student_id,
        $log_date,
        $title,
        $activity,
        $file_name
    );

    if($stmt->execute()){

        header("Location: view-logs.php?success=1");
        exit();

    } else {

        echo "Error saving log entry";

    }
}
?>