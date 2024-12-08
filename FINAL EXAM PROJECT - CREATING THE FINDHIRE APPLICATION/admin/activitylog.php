<?php
require_once('core/dbConfig.php');

$stmt = $pdo->query("SELECT * FROM activity_log ORDER BY created_at DESC");
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Activity Log</title>
</head>
<body>
    <h1>Activity Log</h1>
    <table>
        <thead>
            <tr>
                <th>Timestamp</th>
                <th>User Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($activities): ?>
                <?php foreach ($activities as $activity): ?>
                    <tr>
                        <td><?= $activity['created_at']; ?></td>
                        <td><?= htmlspecialchars($activity['user_role']); ?></td>
                        <td><?= htmlspecialchars($activity['action']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No activity recorded.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
