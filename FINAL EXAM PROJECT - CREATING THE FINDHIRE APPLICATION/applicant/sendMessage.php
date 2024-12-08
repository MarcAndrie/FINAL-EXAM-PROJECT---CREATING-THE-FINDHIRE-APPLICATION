<?php
session_start();
require_once('core/models.php');

// Ensure the user is logged in
$applicantId = $_SESSION['user_id'] ?? null;
if (!$applicantId) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['send_message'])) {
    // Get the message text from the form
    $message = trim($_POST['message']);
    
    if (empty($message)) {
        header('Location: messages.php?error=Message cannot be empty.');
        exit();
    }
    
    // Prepare the query to insert the message
    $stmt = $pdo->prepare("INSERT INTO messages (applicant_id, message, created_at) VALUES (?, ?, NOW())");
    
    // Execute the query
    $stmt->execute([$applicantId, $message]);
    
    // Redirect to the messages page after sending the message
    header('Location: messages.php?success=Message sent successfully!');
    exit();
}
?>
