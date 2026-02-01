<?php
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/auth.php';
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}
$error = null;
if (!empty($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
}
include __DIR__ . '/views/auth/login_form.php';
