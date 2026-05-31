<?php

require_once '../config/db.php';

$id = $_POST['id'];

$title = $_POST['title'];

$description = $_POST['description'];

mysqli_query(

    $conn,

    "

    UPDATE weekly_evidence

    SET

    title='$title',

    description='$description'

    WHERE id='$id'

    "

);

header("Location: weekly-evidence-list.php");
exit();