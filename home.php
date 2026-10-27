<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';

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
    <link rel="stylesheet" href="style.css?v=<?= filemtime(__DIR__ . '/style.css') ?>">
</head>
<body class="home-page">
    <a href="game.js" class="gamebutton">
    <span class="play-icon"></span></a>
    <div class="account-controls">
        <p class="signed-in-text">Signed in as <?= $username ?>.</p>
        <form class="logout-form" action="logout.php" method="post">
            <button class="logout-button" type="submit">Sign out</button>
        </form>
    </div>
</body>
</html>
