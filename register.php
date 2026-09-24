<?php

$melding = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verbinding met XAMPP database
    $conn = new mysqli("localhost", "root", "", "school_project");

    if ($conn->connect_error) {
        die("Verbinding mislukt: " . $conn->connect_error);
    }

    // Gegevens opslaan in de tabel
    $stmt = $conn->prepare("INSERT INTO gebruikers (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $email, $hashed_password);
    
    if ($stmt->execute()) {
        $melding = "<p style='color: green; text-align: center;'>Registratie succesvol! <a href='login.php' class='link'>Log hier in</a></p>";
    } else {
        $melding = "<p style='color: red; text-align: center;'>Fout: " . $conn->error . "</p>";
    }
    
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login</title> <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="login-reg-container" class="registeren">
        <h2 id="h2">Registreren</h2>
        
        <!-- Hier tonen we de melding als iemand zich registreert -->
        <?php echo $melding; ?>

        <form action="register.php" method="POST" id="regForm">
            <label id="label">E-mail:</label>
            <input type="email" name="email" placeholder="naam@voorbeeld.nl" autocomplete="email" required>

            <label id="label">Username:</label>
            <input type="text" name="username" placeholder="Vul je gebruikersnaam in" maxlength="100" autocomplete="username" required>

            <label id="label">Password:</label>
            <input type="password" name="password" id="password" placeholder="Minimaal 8 tekens" minlength="8" autocomplete="new-password" required>

            <label id="text" for="confirm_password">Herhaal wachtwoord:</label>
            <input id="confirm_password" name="confirm_password" type="password" placeholder="Herhaal je wachtwoord" minlength="8" autocomplete="new-password" required>

            <button type="submit" class="login-button">Account aanmaken</button>
        </form>
        <p class="tekst-link">Already have an account? <a href="login.php" class="link">Login here</a></p>
    </div>

    <script>
    // Jouw JavaScript voor de wachtwoordcontrole
    document.getElementById('regForm').addEventListener('submit', function(event) {
      const password = document.getElementById('password').value;
      if (password.length < 8) {
        alert('Password must be at least 8 characters long.');
        event.preventDefault(); 
      }
    });
    </script>
</body>
</html>