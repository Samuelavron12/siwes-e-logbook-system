<?php

$host = "localhost";
$dbname = "e_logbook";
$username = "root";
$password = "";
$port = 3307;

// Create Connection
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check Connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Optional: Set Charset
$conn->set_charset("utf8");

?>