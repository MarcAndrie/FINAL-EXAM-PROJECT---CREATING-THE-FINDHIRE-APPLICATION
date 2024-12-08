<?php
require_once('dbConfig.php');

function getJobPosts() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM job_posts ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMessages($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE sender_id = ? OR receiver_id = ? ORDER BY sent_at DESC");
    $stmt->execute([$userId, $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function checkIfApplied($applicantId, $jobId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT status FROM applications WHERE applicant_id = ? AND job_id = ?");
    $stmt->execute([$applicantId, $jobId]);
    $application = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ensure that if no application is found, we return a safe result.
    return [
        'hasApplied' => !empty($application),
        'status' => $application['status'] ?? 'Not Applied'  // Using null coalescing to check for missing 'status' key
    ];
}

// Save job application to the database
function saveJobApplication($jobId, $applicantId, $reason, $cvPath) {
    global $pdo;
    $query = "INSERT INTO applications (job_id, applicant_id, reason, cv, status, updated_at) 
              VALUES (:jobId, :applicantId, :reason, :cv, 'pending', NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'jobId' => $jobId,
        'applicantId' => $applicantId,
        'reason' => $reason,
        'cv' => $cvPath,
    ]);
}

function getJobPostById($jobId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM job_posts WHERE id = ?");
    $stmt->execute([$jobId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
