<?php
require_once 'core/auth.php';
checkAuth();

$username = $_SESSION['user']['username'];

try {
    // Fetch all job posts
    $stmt = $pdo->query("SELECT * FROM job_posts ORDER BY created_at DESC");
    $jobPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $jobPosts = []; // Initialize as an empty array if there's an error
    error_log("Error fetching job posts: " . $e->getMessage());
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>HR Dashboard</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="manage_applications.php">Manage Applications</a></li>
            <li><a href="admin_messages.php">Messages</a></li> 
            <li><a href="admin_applicants.php">List of Applicants</a></li> 
            <li><a href="logout.php">Logout</a></li> 
        </ul>
    </nav>
    <div class="container">
        <h1>FINDHIRE Job Application System</h1>
        <ul>
            <li><a href="add_job_post.php">Add Job Post</a></li>
        </ul>
    </div>
    <!-- Success Message -->
    <?php if (isset($_GET['success'])): ?>
        <div class="success-message">
            <?= htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>
    <!-- Job Posts -->
    <h2>Job Lists</h2>
    <div class="job-posts">
        <?php if (!empty($jobPosts)): ?>
            <?php foreach ($jobPosts as $job): ?>
                <div class="job-box">
                    <h3><?= htmlspecialchars($job['title']); ?></h3>
                    <p><?= htmlspecialchars($job['description']); ?></p>
                    <a href="edit_job_post.php?id=<?= $job['id']; ?>" class="edit-btn">Edit</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No job posts available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
