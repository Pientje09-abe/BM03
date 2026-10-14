<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';

if (isset($_SESSION['username'])) {
    header('Location: home.php');
    exit;
}

$message = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $user = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = new mysqli('localhost', 'root', '', 'school_project');
        $stmt = $conn->prepare('SELECT password FROM gebruikers WHERE username = ?');
        $stmt->bind_param('s', $user);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        $userExists = $stmt->fetch();

        if ($userExists && password_verify($password, $hashedPassword)) {
            session_regenerate_id(true);
            $_SESSION['username'] = $user;
            $stmt->close();
            $conn->close();
            header('Location: home.php');
            exit;
        }

        $message = $userExists ? 'The password is incorrect.' : 'Username not found.';
        $stmt->close();
        $conn->close();
    } catch (Throwable $error) {
        $message = 'Sign-in is temporarily unavailable. Please try again later.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= filemtime(__DIR__ . '/../assets/css/style.css') ?>">
</head>
<body>

    <div id="login-reg-container" class="login">
        <h2 id="h2">Sign In</h2>
        <?php if ($message !== ''): ?>
            <p class="form-message" role="alert"><?= htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label id="text" for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Enter your username" maxlength="100" autocomplete="username" required>

            <label id="text" for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" autocomplete="current-password" required>

            <button type="submit" class="login-button">Sign In</button>
        </form>
        <p class="text-link">Don't have an account? <a href="register.php" class="link">Register here</a></p>
    </div>

</body>
</html>
