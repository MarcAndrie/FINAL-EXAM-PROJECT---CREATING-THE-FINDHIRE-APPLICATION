<?php
session_start();

// Redirect to home if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle login form submission
    require_once('core/dbConfig.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];  // Store the user ID in the session
            $_SESSION['username'] = $user['username'];  // Store the username

            header('Location: index.php');
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login - FindHire</title>
</head>

<body class="login-page">
    <div class="login-container">
        <div>
            <h2>Applicant Login</h2>

            <?php if (isset($error)): ?>
                <p style="color: red;"><?= $error; ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <label for="username">Username:</label><br>
                <input type="text" name="username" id="username" required><br><br>

                <label for="password">Password:</label><br>
                <input type="password" name="password" id="password" required><br><br>

                <button type="submit">Login</button>
            </form>

            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>
