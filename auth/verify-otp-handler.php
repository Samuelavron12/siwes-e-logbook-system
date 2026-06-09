<?php

require_once '../config/db.php';
require_once '../config/config.php';

if(isset($_POST['verify_otp'])){

    $otp_code = trim($_POST['otp']);

    // Get Email From Session
    $email = $_SESSION['verification_email'];

    // Check OTP
    $check = $conn->prepare("
        SELECT user_id, otp_expiry 
        FROM users 
        WHERE email = ? AND otp_code = ?
    ");

    $check->bind_param("ss", $email, $otp_code);
    $check->execute();

    $result = $check->get_result();

    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        // Check Expiry
        if(strtotime($user['otp_expiry']) < time()){
            die("OTP Expired");
        }

        // Verify User
        $update = $conn->prepare("
            UPDATE users 
            SET is_verified = 1,
                otp_code = NULL,
                otp_expiry = NULL
            WHERE email = ?
        ");

        $update->bind_param("s", $email);

        if($update->execute()){

        unset($_SESSION['verification_email']);
    
        $_SESSION['success_message'] = "Account Verified Successfully. You can now login.";
    
        header("Location: ../login.php");
        exit();
    }

    } else {
        echo "Invalid OTP";
    }

}
?>