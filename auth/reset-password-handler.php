<?php

require_once '../config/db.php';
session_start();

if(isset($_POST['reset'])){

    if(!isset($_SESSION['verified_reset'])){
        die("Unauthorized access");
    }

    $email = $_SESSION['verified_reset'];

    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm_password']);

    if($password !== $confirm){
        die("Passwords do not match");
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $update = $conn->prepare("
        UPDATE users 
        SET password = ?, reset_otp = NULL, reset_otp_expiry = NULL
        WHERE email = ?
    ");

    $update->bind_param("ss", $hashed, $email);

    if($update->execute()){
        session_destroy();
        header("Location: ../login.php?reset=success");
        exit();
    } else {
        echo "Failed to reset password";
    }
}