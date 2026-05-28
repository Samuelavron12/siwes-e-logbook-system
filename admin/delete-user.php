<?php
require_once '../config/db.php';

$id = $_GET['id'];

$conn->query("
    DELETE FROM users
    WHERE user_id = '$id'
");

header("Location: students.php");
exit();
?>