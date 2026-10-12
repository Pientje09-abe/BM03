<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';

$destination = isset($_SESSION['username']) ? 'pages/home.php' : 'pages/login.php';
header('Location: ' . $destination);
exit;
