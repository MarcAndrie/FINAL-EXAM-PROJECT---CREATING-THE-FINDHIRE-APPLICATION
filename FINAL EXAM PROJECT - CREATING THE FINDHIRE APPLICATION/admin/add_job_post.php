<?php require_once 'core/handleForms.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add Job Post</title>
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
    <div class="container">
        <h1>Add a Job Post</h1>
        <?php if (isset($_GET['success'])): ?>
            <p class="success"><?= htmlspecialchars($_GET['success']); ?></p>
        <?php endif; ?>
        <form action="core/handleForms.php" method="POST">
            <label for="title">Job Title:</label>
            <input type="text" id="title" name="title" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" required></textarea>
            
            <button type="submit" name="add_job_post">Post Job</button>
        </form>
    </div>
</body>
</html>
