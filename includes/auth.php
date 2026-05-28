<?php

require_once '../config/config.php';

// Check Login
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}
?>