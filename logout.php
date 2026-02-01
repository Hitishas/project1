<?php
require_once __DIR__ . '/include/auth.php';
logout();
header('Location: login.php');
exit;
