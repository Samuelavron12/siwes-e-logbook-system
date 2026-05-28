<?php
require_once '../config/db.php';

if(isset($_POST['save_comment'])){

    $id = $_POST['id'];

    $comment = $_POST['comment'];

    $stmt = $conn->prepare("
        UPDATE log_entries
        SET supervisor_comment = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "si",
        $comment,
        $id
    );

    if($stmt->execute()){

        header("Location: view-logs.php");
        exit();

    } else {

        echo "Failed to save comment";
    }
}
?>