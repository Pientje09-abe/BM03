<?php

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Connect to the XAMPP database.
    $conn = new mysqli("localhost", "root", "", "school_project");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Save the account details.
    $stmt = $conn->prepare("INSERT INTO gebruikers (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $email, $hashed_password);
    
    if ($stmt->execute()) {
        $message = "<p style='color: green; text-align: center;'>Registration successful! <a href='login.php' class='link'>Sign in here</a></p>";
    } else {
        $message = "<p style='color: red; text-align: center;'>Error: " . $conn->error . "</p>";
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
  <title>Register</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=<?= filemtime(__DIR__ . '/../assets/css/style.css') ?>">
</head>
<body>
    <div id="login-reg-container" class="register">
        <h2 id="h2">Create an account</h2>
        
        <!-- Display the registration result. -->
        <?php echo $message; ?>

        <form action="register.php" method="POST" id="regForm">
            <label id="label">Email:</label>
            <input type="email" name="email" placeholder="Name@example.com" autocomplete="email" required>

            <label id="label">Username:</label>
            <input type="text" name="username" placeholder="Enter your username" maxlength="100" autocomplete="username" required>

            <label id="label">Password:</label>
            <input type="password" name="password" id="password" placeholder="At least 8 characters" minlength="8" autocomplete="new-password" required>

            <label id="text" for="confirm_password">Confirm password:</label>
            <input id="confirm_password" name="confirm_password" type="password" placeholder="Enter your password again" minlength="8" autocomplete="new-password" required>

            <button type="submit" class="login-button">Create account</button>
        </form>
        <p class="text-link">Already have an account? <a href="login.php" class="link">Sign in here</a></p>
    </div>

    <script src="../assets/js/register-validation.js"></script>
</body>
</html>
