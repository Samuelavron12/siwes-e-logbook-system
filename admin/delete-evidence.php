<?php

require_once '../config/db.php';

$id = $_GET['id'];

$get = mysqli_query(

    $conn,

    "

    SELECT evidence_file

    FROM weekly_evidence

    WHERE id='$id'

    "

);

$row = mysqli_fetch_assoc($get);

$file =

"../uploads/evidence/"

.$row['evidence_file'];

if(file_exists($file)){

    unlink($file);

}

mysqli_query(

    $conn,

    "

    DELETE FROM weekly_evidence

    WHERE id='$id'

    "

);

header("Location: all-evidence.php");
exit();