<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "No session found. User is not logged in.";
    exit();
}

// Fetch messages for the logged-in user
require_once('core/models.php');

// Assuming getMessages() needs modification to include sender names
$messages = getMessagesWithSenderName($_SESSION['user_id']); // Use the updated function
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - FindHire</title>
</head>
<body>
    <nav>
        <a href="admin_messages.php">Messages</a>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h1>Messages</h1>

    <?php if (empty($messages)): ?>
        <p>No messages found.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($messages as $message): ?>
                <li>
                    <p><strong>Sender:</strong> <?= htmlspecialchars($message['sender_name']) ?></p> <!-- Display sender's name -->
                    <p><strong>Message:</strong> <?= htmlspecialchars($message['message']) ?></p>
                    <p><small>Sent at: <?= htmlspecialchars($message['created_at']) ?></small></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
