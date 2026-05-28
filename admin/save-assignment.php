<?php
require_once '../config/db.php';

if(isset($_POST['assign_supervisor'])){

    $student_id = $_POST['student_id'];

    $supervisor_id = $_POST['supervisor_id'];

    /* CHECK EXISTING */

    $check = $conn->query("
        SELECT * FROM student_supervisors
        WHERE student_id = '$student_id'
    ");

    if($check->num_rows > 0){

        $conn->query("
            UPDATE student_supervisors
            SET supervisor_id = '$supervisor_id'
            WHERE student_id = '$student_id'
        ");

    } else {

        $conn->query("
            INSERT INTO student_supervisors(
                student_id,
                supervisor_id
            )

            VALUES(
                '$student_id',
                '$supervisor_id'
            )
        ");
    }

    header("Location: assign-supervisor.php");
    exit();
}
?>