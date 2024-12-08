<?php
session_start();
require_once('core/dbConfig.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiverId = $_POST['receiver_id'];
    $message = trim($_POST['message']);
    $senderId = $_SESSION['user_id'];

    if (empty($receiverId) || empty($message)) {
        $error = "Receiver and message cannot be empty.";
    } else {
        // Insert message into database
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message, sent_at) VALUES (:sender_id, :receiver_id, :message, NOW())");
        $stmt->execute([
            ':sender_id' => $senderId,
            ':receiver_id' => $receiverId,
            ':message' => $message
        ]);
        header('Location: messages.php?success=Message sent successfully.');
        exit();
    }
}
?>

<!-- Message form will be placed in the messages.php page -->
