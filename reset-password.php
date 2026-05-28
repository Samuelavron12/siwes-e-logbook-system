<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
<form action="auth/reset-password-handler.php" method="POST">
    <h2>Create New Password</h2>
    <input type="password" name="password" placeholder="New Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    <button type="submit" name="reset">
        Reset Password
    </button>
</form>

</body>
</html>