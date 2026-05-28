<?php
require_once '../config/db.php';

if(isset($_POST['update_log'])){

    $id = $_POST['id'];

    $log_date = $_POST['log_date'];

    $title = $_POST['title'];

    $activity = $_POST['activity'];

    $stmt = $conn->prepare("
        UPDATE log_entries
        SET
        log_date = ?,
        title = ?,
        activity = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "sssi",
        $log_date,
        $title,
        $activity,
        $id
    );

    if($stmt->execute()){

        header("Location: view-logs.php");
        exit();

    } else {

        echo "Update Failed";

    }
}
?>