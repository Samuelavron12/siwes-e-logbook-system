<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/auth.css">
    <title>Verify OTP</title>
</head>
<body>

<div class="otp-container">

    <form action="auth/verify-otp-handler.php" method="POST">

        <h2>Verify Account</h2>

        <!-- SUCCESS MESSAGE -->
        <?php
        if(isset($_SESSION['success_message'])){
            echo "<p class='success-message'>"
                 . $_SESSION['success_message'] .
                 "</p>";

            unset($_SESSION['success_message']);
        }
        ?>

        <input type="text" name="otp" class="otp-input" maxlength="4">
        <button type="submit" name="verify_otp">
            Verify
        </button>

    </form>

</div>

</body>
</html>