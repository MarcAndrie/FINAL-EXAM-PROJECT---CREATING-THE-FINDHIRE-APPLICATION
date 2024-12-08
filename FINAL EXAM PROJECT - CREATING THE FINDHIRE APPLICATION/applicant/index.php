<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once('core/models.php');

$jobPosts = getJobPosts();
$applicantId = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home - FindHire</title>
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="messages.php">Messages</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h1>Available Job Posts</h1>

    <?php if (empty($jobPosts)): ?>
        <p>No job posts available.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($jobPosts as $job): ?>
                <div class="job-post">
                    <h2><?= htmlspecialchars($job['title']) ?></h2>
                    <p><?= htmlspecialchars($job['description']) ?></p>
                    <?php 
                    $applicationStatus = checkIfApplied($applicantId, $job['id']);
        
                    if ($applicationStatus['hasApplied']): ?>
                        <p>Status: <?= htmlspecialchars($applicationStatus['status']) ?></p>
                    <?php else: ?>
                        <a href="apply.php?job_id=<?= $job['id'] ?>">Apply Now</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
