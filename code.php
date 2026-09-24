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
    $errors[] = 'Dit formulier kan alleen worden verzonden via de registratiepagina.';
} else {
    if ($name === '' || strlen($name) > 100) {
        $errors[] = 'Vul een naam in van maximaal 100 tekens.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Vul een geldig e-mailadres in.';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Kies een wachtwoord van minimaal 8 tekens.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'De wachtwoorden komen niet overeen.';
    }

}

if ($isPost && !$errors) {
    header('Location: login.html?registered=1');
    exit;
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie resultaat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main id="login-reg-container" class="registeren">
        <h1 id="h2">Registratie</h1>

        <?php if ($errors): ?>
            <div class="form-message" role="alert">
                <p>Controleer de volgende gegevens:</p>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= escape($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <p class="form-message" role="status">
                De ingevulde gegevens zijn geldig. Er is nog geen account opgeslagen; daarvoor is een databasekoppeling nodig.
            </p>
        <?php endif; ?>

        <p><a class="link" href="register.html">Terug naar registreren</a></p>
    </main>
</body>
</html>
