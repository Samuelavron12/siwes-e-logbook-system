<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/../vendor/PHPMailer/src/Exception.php';
require __DIR__ . '/../vendor/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../vendor/PHPMailer/src/SMTP.php';
function sendOTP($email, $otp_code){

    $mail = new PHPMailer(true);

    try {

        // SMTP SETTINGS
        $mail->isSMTP();

        // Gmail SMTP Server
        $mail->Host = 'smtp.gmail.com';

        // Enable SMTP Authentication
        $mail->SMTPAuth = true;

        // Your Gmail
        $mail->Username = 'saikisamuel5@gmail.com';  //app account email

        // Your App Password
        $mail->Password = 'szjq woaq exqq whfo';  // app acount password. without this the whole process won't work

        // Encryption protocol
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        // Gmail Port  for connection
        $mail->Port = 587;

        // Sender
        $mail->setFrom(
            'yourgmail@gmail.com',
            'SIWES E-Logbook'
        );

        // Receiver
        $mail->addAddress($email);

        // Email Format  to be shown  in the message sent
        $mail->isHTML(true);

        // Email Subject
        $mail->Subject = 'Email Verification OTP';

        // Email Body
        $mail->Body = "
            <h2>SIWES E-Logbook Verification</h2>

            <p>Your OTP Code is:</p>

            <h1>$otp_code</h1>

            <p>This code expires in 10 minutes.</p>
            
            <p>contact our team for further issues on verification.</p>
        ";

        // Send Email
       
        $mail->send();

        return true;

    } catch (Exception $e) {

    echo $mail->ErrorInfo;

}

}
?>