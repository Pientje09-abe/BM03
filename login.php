<?php
// DIT MOET HELEMAAL BOVENAAN STAAN IN login.php
$melding = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli("localhost", "root", "", "school_project");

    if ($conn->connect_error) {
        die("Verbinding mislukt: " . $conn->connect_error);
    }

    // Zoek de gebruiker op basis van de gebruikersnaam
    $stmt = $conn->prepare("SELECT password FROM gebruikers WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        
        // Controleer of het ingevoerde wachtwoord klopt met het gehashte wachtwoord
        if (password_verify($password, $hashed_password)) {
            $melding = "<p style='color: green; text-align: center;'>Je bent succesvol ingelogd!</p>";
        } else {
            $melding = "<p style='color: red; text-align: center;'>Onjuist wachtwoord.</p>";
        }
    } else {
        $melding = "<p style='color: red; text-align: center;'>Gebruikersnaam bestaat niet.</p>";
    }
    
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

    <div id="login-reg-container" class="login">
        <h2 id="h2">Inloggen</h2>
        
        <?php echo $melding; ?>

        <form action="login.php" method="POST">
            <label id="label">Username:</label>
            <input type="text" name="username" required>

            <label id="label">Password:</label>
            <input type="password" name="password" required>

            <button type="submit" class="login-button">Login</button>
        </form>
        <p class="tekst-link">Don't have an account? <a href="register.php" class="link">Register here</a></p>
    </div>

</body>
</html>