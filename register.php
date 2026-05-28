<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<div class="register-container">

    <form action="auth/register-handler.php" method="POST">

        <h2>Create Account</h2>

        <input type="text" name="full_name" placeholder="Full Name" required>

        <input type="email" name="email" placeholder="Email Address" required>

        <input type="text" name="phone_number" placeholder="Phone Number" required>

        <input type="password" name="password" placeholder="Password" required>

        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <button type="submit" name="register">
            Register
        </button>
      <p>already have an account<a href="login.php">
            login
        </a> </p>

    </form>

</div>

</body>
</html>