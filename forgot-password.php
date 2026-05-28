<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>



<form action="auth/forgot-password-handler.php" method="POST">
    <h2>Forgot Password</h2>
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit" name="recover">
        Send Reset Code
    </button>
</form>

</body>
</html>