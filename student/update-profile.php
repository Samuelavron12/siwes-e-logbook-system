<?php
require_once '../config/db.php';

if(isset($_POST['update_profile'])){

    $id = $_POST['profile_id'];

    $stmt = $conn->prepare("
        UPDATE student_profiles
        SET

        matric_no = ?,
        school = ?,
        faculty = ?,
        department = ?,
        level = ?,
        company_name = ?,
        company_address = ?,
        industry_supervisor = ?,
        supervisor_phone = ?

        WHERE profile_id = ?
    ");

    $stmt->bind_param(

        "sssssssssi",

        $_POST['matric_no'],
        $_POST['school'],
        $_POST['faculty'],
        $_POST['department'],
        $_POST['level'],
        $_POST['company_name'],
        $_POST['company_address'],
        $_POST['industry_supervisor'],
        $_POST['supervisor_phone'],
        $id
    );

    if($stmt->execute()){

        header("Location: profile.php");
        exit();
    }
}
?>