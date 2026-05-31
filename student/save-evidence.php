<?php

require_once '../config/db.php';

if(isset($_POST['upload_evidence'])){

    session_start();

    $student_id = $_SESSION['user_id'];

    $week_no = $_POST['week_no'];

    $title = $_POST['title'];

    $description = $_POST['description'];

    /* FILE VALIDATION */

    $allowed = [

        'jpg',
        'jpeg',
        'png',
        'pdf'

    ];

    $extension = strtolower(

        pathinfo(

            $_FILES['evidence_file']['name'],

            PATHINFO_EXTENSION

        )

    );

    if(!in_array($extension, $allowed)){

        die("Invalid file type.");

    }

    /* CHECK DUPLICATE WEEK */

    $check = mysqli_query(

        $conn,

        "

        SELECT *

        FROM weekly_evidence

        WHERE student_id = '$student_id'

        AND week_no = '$week_no'

        "

    );

    if(mysqli_num_rows($check) > 0){

    header("Location: weekly-evidence.php?error=week_exists");

    exit();

}

    /* FILE UPLOAD */

    $file_name = time() . "_" .
                 $_FILES['evidence_file']['name'];

    $tmp = $_FILES['evidence_file']['tmp_name'];

    move_uploaded_file(

        $tmp,

        "../uploads/evidence/" . $file_name

    );

    /* SAVE TO DATABASE */

    mysqli_query(

        $conn,

        "

        INSERT INTO weekly_evidence(

            student_id,
            week_no,
            title,
            description,
            evidence_file

        )

        VALUES(

            '$student_id',
            '$week_no',
            '$title',
            '$description',
            '$file_name'

        )

        "

    );

    header("Location: weekly-evidence-list.php");

    exit();
}
?>