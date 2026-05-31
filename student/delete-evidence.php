<?php

require_once '../config/db.php';

$id = $_GET['id'];

mysqli_query(

    $conn,

    "

    DELETE FROM weekly_evidence

    WHERE id='$id'

    "

);

header("Location: weekly-evidence-list.php");
exit();