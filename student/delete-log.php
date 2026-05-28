<?php
require_once '../config/db.php';

$id = $_GET['id'];

$conn->query("
    DELETE FROM log_entries
    WHERE id = '$id'
");

header("Location: view-logs.php");
exit();
?>