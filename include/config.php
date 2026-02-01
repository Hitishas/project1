<?php
// Database configuration - update these values for your environment
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hotel_management');

// Create mysqli connection
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_errno) {
    error_log('Database connection failed: ' . $con->connect_error);
    die('Database connection failed.');
}

// Set charset
$con->set_charset('utf8mb4');
?>