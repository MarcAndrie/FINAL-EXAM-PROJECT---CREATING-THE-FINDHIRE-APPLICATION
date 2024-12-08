<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Manage Applications</title>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="manage_applications.php">Manage Applications</a></li>
            <li><a href="admin_messages.php">Messages</a></li>
            <li><a href="applicants.php">List of Applicants</a></li> 
            <li><a href="logout.php">Logout</a></li> 
        </ul>
    </nav>
    <div class="manage_application-container">
        <h1>Manage Applications</h1>
        <?php if (isset($_GET['success'])): ?>
            <p class="success"><?= htmlspecialchars($_GET['success']); ?></p>
        <?php endif; ?>

        <table>
            <tr>
                <th>Job Title</th>
                <th>Applicant</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php $applications = getApplications(); ?>
            <?php foreach ($applications as $application): ?>
            <tr>
                <td><?= htmlspecialchars($application['job_title']); ?></td>
                <td><?= htmlspecialchars($application['applicant_name']); ?></td>
                <td><?= htmlspecialchars($application['status']); ?></td>
                <td>
                    <form action="core/handleForms.php" method="POST">
                        <input type="hidden" name="application_id" value="<?= $application['id']; ?>">
                        <select name="status" required>
                            <option value="Accepted">Accept</option>
                            <option value="Rejected">Reject</option>
                        </select>
                        <button type="submit" name="update_status">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
