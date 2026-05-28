<?php

require_once '../config/db.php';
require_once '../config/mail.php';

session_start();

if(isset($_POST['recover'])){

    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows == 0){
        die("No account found with this email");
    }

    $reset_otp = rand(1000, 9999);
    $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

    $update = $conn->prepare("
        UPDATE users 
        SET reset_otp = ?, reset_otp_expiry = ?
        WHERE email = ?
    ");

    $update->bind_param("sss", $reset_otp, $expiry, $email);
    $update->execute();

    if(sendOTP($email, $reset_otp)){

        $_SESSION['reset_email'] = $email;

        header("Location: ../verify-reset-code.php");
        exit();

    } else {
        echo "Failed to send OTP";
    }
}