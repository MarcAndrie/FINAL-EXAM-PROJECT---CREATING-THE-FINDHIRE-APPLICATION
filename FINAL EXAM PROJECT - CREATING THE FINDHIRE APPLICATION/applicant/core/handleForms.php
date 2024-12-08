<?php
require_once('dbConfig.php');
require_once('models.php');
session_start();

// Handle job application submission
if (isset($_POST['submit_application'])) {
    $jobId = $_POST['job_id'] ?? null;
    $applicantId = $_SESSION['user_id'] ?? null;
    $reason = trim($_POST['reason'] ?? '');

    // Validate form data
    if (!$jobId || !$applicantId || empty($reason)) {
        header("Location: ../apply.php?job_id=$jobId&error=All%20fields%20are%20required.");
        exit();
    }

    // Check if the applicant has already applied for this job
    if (checkIfApplied($applicantId, $jobId)['hasApplied']) {
        header("Location: ../apply.php?job_id=$jobId&error=You%20have%20already%20applied%20for%20this%20job.");
        exit();
    }

    // Handle CV upload
    if (!isset($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../apply.php?job_id=$jobId&error=CV%20upload%20failed.");
        exit();
    }

    $cvFile = $_FILES['cv'];
    $allowedMime = ['application/pdf'];

    // Define the upload directory path
    $uploadDir = realpath(__DIR__ . '/../uploads/') . '/';
    $cvPath = $uploadDir . basename($cvFile['name']);

    // Validate the CV file type and extension
    if (!in_array($cvFile['type'], $allowedMime) || pathinfo($cvPath, PATHINFO_EXTENSION) !== 'pdf') {
        header("Location: ../apply.php?job_id=$jobId&error=Invalid%20CV%20format.%20Only%20PDF%20allowed.");
        exit();
    }

    // Ensure the upload directory exists and is writable
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
    }
    if (!is_writable($uploadDir)) {
        header("Location: ../apply.php?job_id=$jobId&error=Upload%20directory%20is%20not%20writable.");
        exit();
    }

    // Move the uploaded CV to the target directory
    if (!move_uploaded_file($cvFile['tmp_name'], $cvPath)) {
        header("Location: ../apply.php?job_id=$jobId&error=Failed%20to%20save%20CV.");
        exit();
    }

    // Save the application in the database
    saveJobApplication($jobId, $applicantId, $reason, $cvPath);

    // Redirect to the home page after successful submission
    header("Location: ../index.php?success=Application%20successfully%20submitted!");
    exit();
}
?>
