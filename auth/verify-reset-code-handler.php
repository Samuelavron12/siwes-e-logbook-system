<?php

require_once '../config/db.php';
session_start();

if(isset($_POST['verify'])){

    if(!isset($_SESSION['reset_email'])){
        die("Session expired. Restart process.");
    }

    $otp = trim($_POST['otp']);
    $email = $_SESSION['reset_email'];

    $stmt = $conn->prepare("
        SELECT reset_otp, reset_otp_expiry 
        FROM users 
        WHERE email = ?
    ");

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($db_otp, $expiry);
    $stmt->fetch();

    if(!$db_otp){
        die("No OTP found. Request again.");
    }

    if((string)$otp !== (string)$db_otp){
        die("Invalid code");
    }

    if(strtotime($expiry) < time()){
        die("Code expired");
    }

    $_SESSION['verified_reset'] = $email;

    header("Location: ../reset-password.php");
    exit();
}