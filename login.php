<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<div class="login-container">

    <form action="auth/login-handler.php" method="POST">
        <?php
        session_start();
        if(isset($_SESSION['success_message'])){
            echo "<p class='success'>".$_SESSION['success_message']."</p>";
            unset($_SESSION['success_message']);
        }
        ?>

        <h2>Login</h2>

        <input type="email"
               name="email"
               placeholder="Email Address"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <button type="submit" name="login">
            Login
        </button>

        <br><br>

        <a href="forgot-password.php">
            Forgot Password?
        </a>

        <br><br>

        <a href="register.php">
            Create Account
        </a>

    </form>

</div>

</body>
</html>