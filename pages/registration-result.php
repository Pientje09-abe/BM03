<?php
declare(strict_types=1);

$errors = [];
$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$password = (string) ($_POST['password'] ?? '');
$confirmPassword = (string) ($_POST['confirm_password'] ?? '');
$isPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if (!$isPost) {
    http_response_code(405);
    header('Allow: POST');
    $errors[] = 'This form can only be submitted from the registration page.';
} else {
    if ($name === '' || strlen($name) > 100) {
        $errors[] = 'Enter a name with no more than 100 characters.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Choose a password with at least 8 characters.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'The passwords do not match.';
    }

}

if ($isPost && !$errors) {
    header('Location: login.php?registered=1');
    exit;
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Result</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= filemtime(__DIR__ . '/../assets/css/style.css') ?>">
</head>
<body>
    <main id="login-reg-container" class="register">
        <h1 id="h2">Registration</h1>

        <?php if ($errors): ?>
            <div class="form-message" role="alert">
                <p>Please check the following details:</p>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= escape($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <p class="form-message" role="status">
                The details you entered are valid. No account has been saved yet; a database connection is required.
            </p>
        <?php endif; ?>

        <p><a class="link" href="register.php">Back to registration</a></p>
    </main>
</body>
</html>
