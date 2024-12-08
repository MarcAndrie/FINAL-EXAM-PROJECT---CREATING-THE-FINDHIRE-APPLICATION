<?php
session_start();
require_once('core/models.php');

$jobId = $_GET['job_id'] ?? null;
$applicantId = $_SESSION['user_id'] ?? null;

if (!$jobId || !$applicantId) {
    header('Location: index.php');
    exit();
}

// Check if the applicant has already applied for this job
$applicationStatus = checkIfApplied($applicantId, $jobId);

if ($applicationStatus['hasApplied']) {
    // Redirect with an error message if already applied
    header("Location: index.php?error=You%20have%20already%20applied%20for%20this%20job.");
    exit();
}

// Fetch job details
$jobPost = getJobPostById($jobId);
if (!$jobPost) {
    header('Location: index.php?error=Job%20not%20found.');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Apply - FindHire</title>
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="messages.php">Messages</a>
        <a href="logout.php">Logout</a>
    </nav>
    
    <h1>Apply for Job: <?= htmlspecialchars($jobPost['title']) ?></h1>

    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="job_id" value="<?= $jobId ?>">
        <textarea name="reason" placeholder="Why are you the best candidate for this job?" required></textarea>
        <input type="file" name="cv" accept="application/pdf" required>
        <button type="submit" name="submit_application">Submit Application</button>
    </form>
</body>
</html>
