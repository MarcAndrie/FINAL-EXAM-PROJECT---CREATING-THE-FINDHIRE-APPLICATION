<?php
require_once('core/dbConfig.php');
require_once('core/models.php');
require_once('core/handleForms.php');

if (!isset($_GET['id'])) {
    die('Job post ID is required.');
}

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM job_posts WHERE id = :id");
$stmt->execute([':id' => $id]);
$job = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$job) {
    die('Job post not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Edit Job Post</title>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="manage_applications.php">Manage Applications</a></li>
            <li><a href="admin_messages.php">Messages</a></li>
            <li><a href="activitylog.php">Activity Log</a></li> 
            <li><a href="applicants.php">List of Applicants</a></li> 
            <li><a href="logout.php">Logout</a></li> 
        </ul>
    </nav>
    <h1>Edit Job Post</h1>
    <form action="core/handleForms.php" method="post">
        <input type="hidden" name="id" value="<?= $job['id']; ?>">
        <label for="title">Job Title:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($job['title']); ?>" required>
        
        <label for="description">Job Description:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($job['description']); ?></textarea>
        
        <button type="submit" name="edit_job_post">Update Job Post</button>
    </form>
</body>
</html>
