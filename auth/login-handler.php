<?php

require_once '../config/db.php';
require_once '../config/config.php';

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Find User
    $check = $conn->prepare("
        SELECT * FROM users
        WHERE email = ?
        LIMIT 1
    ");

    $check->bind_param("s", $email);
    $check->execute();

    $result = $check->get_result();

    // Check User Exists
    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        // Verify Password
        if(password_verify($password, $user['password'])){

            // Check Email Verification
            if($user['is_verified'] == 0){
                die("Please verify your email first");
            }

            // Check Account Status
            if($user['account_status'] != 'active'){
                die("Your account has been suspended");
            }

            // Create Sessions
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Update Last Login
            $update = $conn->prepare("
                UPDATE users
                SET last_login = NOW()
                WHERE user_id = ?
            ");

            $update->bind_param("i", $user['user_id']);
            $update->execute();

            // Redirect By Role
            if($user['role'] == 'student'){

                header("Location: ../student/dashboard.php");

            } elseif($user['role'] == 'supervisor'){

                header("Location: ../supervisor/dashboard.php");

            } elseif($user['role'] == 'admin'){

                header("Location: ../admin/dashboard.php");

            }

            exit();

        } else {

            echo "Incorrect Password";

        }

    } else {

        echo "Account Not Found";

    }

}
?>