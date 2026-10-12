<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = htmlspecialchars((string) $_SESSION['username'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Maze Escape Room</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <img class="img1" src="../assets/images/maze.png" alt="Maze">
    <p class="text-link">Signed in as <?= $username ?>. <a class="link" href="logout.php">Sign out</a></p>
</body>
</html>
