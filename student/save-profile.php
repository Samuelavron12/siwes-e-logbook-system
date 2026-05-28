<?php
require_once '../config/db.php';
session_start();

if(isset($_POST['save_profile'])){

    $student_id = $_SESSION['user_id'];
    /* IMAGE */

    $passport = "";
    
    if(isset($_FILES['passport'])
       && $_FILES['passport']['error'] == 0){
    
        $extension = pathinfo(
            $_FILES['passport']['name'],
            PATHINFO_EXTENSION
        );
    
        $passport =
        time() . "_" .
        rand(1000,9999) .
        "." . $extension;
    
        $destination =
        "../uploads/" . $passport;
    
        move_uploaded_file(
            $_FILES['passport']['tmp_name'],
            $destination
        );
    }
    $stmt = $conn->prepare("
        INSERT INTO student_profiles(

            student_id,
            matric_no,
            school,
            faculty,
            department,
            level,
            gender,
            address,
            passport,
            company_name,
            company_address,
            industry_supervisor,
            supervisor_phone,
            start_date,
            end_date

        ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "issssssssssssss",

        $student_id,
        $_POST['matric_no'],
        $_POST['school'],
        $_POST['faculty'],
        $_POST['department'],
        $_POST['level'],
        $_POST['gender'],
        $_POST['address'],
        $passport,
        $_POST['company_name'],
        $_POST['company_address'],
        $_POST['industry_supervisor'],
        $_POST['supervisor_phone'],
        $_POST['start_date'],
        $_POST['end_date']
    );

    if($stmt->execute()){

        header("Location: profile.php");
        exit();
    }
}
?>