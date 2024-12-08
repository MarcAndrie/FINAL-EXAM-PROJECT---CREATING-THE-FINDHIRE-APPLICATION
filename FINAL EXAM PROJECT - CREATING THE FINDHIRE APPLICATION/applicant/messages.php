<?php
session_start();
require_once('core/models.php');

// Get applicant's ID from the session
$applicantId = $_SESSION['user_id'] ?? null;

// Ensure the applicant is logged in
if (!$applicantId) {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM messages WHERE applicant_id = ? ORDER BY created_at DESC");
$stmt->execute([$applicantId]);  // Passing the applicant_id as an array

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Messages - FindHire</title>
</head>
<body>
    <nav>
        <a href="index.php" class="btn btn-primary">Home</a>
        <a href="profile.php">Profile</a>
        <a href="messages.php">Messages</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h1>Your Messages</h1>

    <!-- Show success or error messages -->
    <?php
    if (isset($_GET['success'])) {
        echo '<p style="color: green;">' . htmlspecialchars($_GET['success']) . '</p>';
    }

    if (isset($_GET['error'])) {
        echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
    }
    ?>

    <!-- Message form -->
    <form action="sendMessage.php" method="POST">
        <textarea name="message" placeholder="Write your message..." required></textarea>
        <button type="submit" name="send_message">Send Message</button>
    </form>

    <h2>Sent Messages</h2>
    <?php if (empty($messages)): ?>
        <p>No messages sent yet.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($messages as $message): ?>
                <li>
                    <p><strong>Message:</strong> <?= htmlspecialchars($message['message']) ?></p>
                    <p><em>Sent on: <?= date('Y-m-d H:i:s', strtotime($message['created_at'])) ?></em></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
