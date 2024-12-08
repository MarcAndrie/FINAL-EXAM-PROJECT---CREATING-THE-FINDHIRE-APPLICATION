<?php
session_start();
require_once('core/dbConfig.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_DEFAULT) : $user['password'];

    if (empty($username) || empty($email)) {
        $error = "All fields are required.";
    } else {
        // Update profile
        $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id");
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':id' => $userId
        ]);
        $success = "Profile updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Profile - FindHire</title>
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="messages.php">Messages</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h1>Update Profile</h1>
    <?php if (isset($success)) echo "<p>$success</p>"; ?>
    <form method="POST" action="">
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" placeholder="Username" required><br>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="New Password (leave empty to keep current)"><br>
        <button type="submit">Update Profile</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
