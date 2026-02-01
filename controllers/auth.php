<?php
require_once __DIR__ . '/../include/auth.php';
require_once __DIR__ . '/../models/User.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';
if ($action === 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (login($email, $password)) {
        header('Location: /dashboard.php');
        exit;
    }
    header('Location: /login.php?error=invalid_credentials');
    exit;
} elseif ($action === 'logout') {
    logout();
    header('Location: /login.php');
    exit;
}

http_response_code(400);
echo 'Bad request';
