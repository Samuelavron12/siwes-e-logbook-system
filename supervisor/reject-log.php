<?php
require_once '../config/db.php';

$id = $_GET['id'];

$conn->query("
    UPDATE log_entries
    SET status = 'rejected'
    WHERE id = '$id'
");

header("Location: view-logs.php");
exit();
?>