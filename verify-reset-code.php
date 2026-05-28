<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Reset Code</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<div class="login-container">

    <form action="auth/verify-reset-code-handler.php" method="POST">

        <h2>Enter Reset Code</h2>

        <input type="text" name="otp" class="otp-input" maxlength="4">

        <button type="submit" name="verify">
            Verify Code
        </button>

    </form>

</div>

</body>
</html>