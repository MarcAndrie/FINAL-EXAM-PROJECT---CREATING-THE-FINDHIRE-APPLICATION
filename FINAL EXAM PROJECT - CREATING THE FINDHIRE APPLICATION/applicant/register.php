<?php
session_start();

// Redirect to home if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle registration form submission
    require_once('core/dbConfig.php');

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'applicant')");
        $stmt->execute([$username, $email, $passwordHash]);

        // Redirect to login page
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FindHire</title>
</head>
<body>

<h2>Applicant Registration</h2>

<?php if (isset($error)): ?>
    <p style="color: red;"><?= $error; ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label for="username">Username:</label><br>
    <input type="text" name="username" id="username" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" id="email" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password" required><br><br>

    <label for="confirm_password">Confirm Password:</label><br>
    <input type="password" name="confirm_password" id="confirm_password" required><br><br>

    <button type="submit">Register</button>
</form>

<p>Already have an account? <a href="login.php">Login here</a></p>

</body>
</html>
