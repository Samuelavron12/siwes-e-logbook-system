<?php
require_once '../config/mail.php';
require_once '../config/db.php';
require_once '../config/config.php';

if(isset($_POST['register'])){

    // Collect Form Data
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate Password Match
    if($password !== $confirm_password){
        die("Passwords do not match");
    }

    // Check Existing Email
    $check_email = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if($check_email->num_rows > 0){
        die("Email already exists");
    }

    // Check Existing Phone Number
    $check_phone = $conn->prepare("SELECT user_id FROM users WHERE phone_number = ?");
    $check_phone->bind_param("s", $phone_number);
    $check_phone->execute();
    $check_phone->store_result();

    if($check_phone->num_rows > 0){
        die("Phone number already exists");
    }

    // Hash Password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate 4 Digit OTP
    $otp_code = rand(1000, 9999);

    // OTP Expiry Time (10 Minutes)
    $otp_expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

    // Insert User
    $insert = $conn->prepare("
        INSERT INTO users 
        (full_name, email, phone_number, password, otp_code, otp_expiry)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $insert->bind_param(
        "ssssss",
        $full_name,
        $email,
        $phone_number,
        $hashed_password,
        $otp_code,
        $otp_expiry
    );
    if($insert->execute()){

    // Store Email In Session
    $_SESSION['verification_email'] = $email;

    // Send OTP Email
    if(sendOTP($email, $otp_code)){

        // Success Message
        $_SESSION['success_message'] = 
        "OTP has been sent to your email address.";

        // Redirect To OTP Page
        header("Location: ../verify-otp.php");
        exit();

    } else {

        echo "Failed to send OTP email.";

    }

} else {

    echo "Something went wrong.";

}
}

?>