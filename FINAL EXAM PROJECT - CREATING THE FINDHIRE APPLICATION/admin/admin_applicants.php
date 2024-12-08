<?php
session_start();

// Check if the user is logged in and is an admin/HR
if (!isset($_SESSION['user_id'])) {
    echo "No session found. User is not logged in.";
    exit();
}

// Fetch the list of applicants
require_once('core/models.php');
$applicants = getAllApplicants();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicants - FindHire</title>
</head>
<body>
    <nav>
        <a href="admin_applicants.php">Applicants</a>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h1>List of Applicants</h1>

    <?php if (empty($applicants)): ?>
        <p>No applicants found.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($applicants as $applicant): ?>
                <li>
                    <p><strong>Username:</strong> <?= htmlspecialchars($applicant['username']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($applicant['email']) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
