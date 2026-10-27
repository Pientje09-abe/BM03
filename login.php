<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="style.css?v=<?= filemtime(__DIR__ . '/style.css') ?>">
</head>
<body class="auth-page auth-page--login">
    <main class="auth-layout">
        <section class="auth-card" aria-labelledby="auth-title">
            <div class="auth-card-heading">
                
                <h1 class="auth-title" id="auth-title">Welcome</h1>
                <p class="auth-subtitle">Sign in to continue your escape room adventure.</p>
            </div>

            <?php if ($message !== ''): ?>
                <p class="form-message" role="alert"><?= htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
            <?php endif; ?>

            <form class="auth-form" action="login.php" method="POST" id="loginForm">
                <div class="form-field">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter your username" maxlength="100" autocomplete="username" required>
                </div>

                <div class="form-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" autocomplete="current-password" required>
                </div>

                <button type="submit" class="login-button">Sign in <span aria-hidden="true">→</span></button>
            </form>
            <p class="text-link">New to the maze? <a href="register.php" class="link">Create an account</a></p>
            <p class="auth-footnote"><span aria-hidden="true">◇</span> Your next clue is just around the corner.</p>
        </section>
    </main>
    <script src="auth-transitions.js?v=<?= filemtime(__DIR__ . '/auth-transitions.js') ?>"></script>
</body>
</html>
