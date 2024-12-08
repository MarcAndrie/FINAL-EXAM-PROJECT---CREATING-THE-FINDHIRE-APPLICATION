<?php
require_once 'dbConfig.php';

function login($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]); // Assuming password is stored in plain text (hash for security!)
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Add a job post
function addJobPost($title, $description) {
    global $pdo;
    $sql = "INSERT INTO job_posts (title, description) VALUES (:title, :description)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':title' => $title, ':description' => $description]);
}

// Retrieve all job posts
function getJobPosts() {
    global $pdo;
    $sql = "SELECT * FROM job_posts ORDER BY created_at DESC";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// Retrieve all applications
function getApplications() {
    global $pdo;
    $sql = "SELECT a.id, a.status, a.updated_at, u.username as applicant_name, j.title as job_title
            FROM applications a
            JOIN users u ON a.applicant_id = u.id
            JOIN job_posts j ON a.job_id = j.id
            ORDER BY a.updated_at DESC";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// Update application status
function updateApplicationStatus($applicationId, $status) {
    global $pdo;
    $sql = "UPDATE applications SET status = :status WHERE id = :applicationId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':status' => $status, ':applicationId' => $applicationId]);
}

// Get messages from applicants
function getMessages() {
    global $pdo;
    $sql = "SELECT m.message, m.created_at, u.username as applicant_name 
            FROM messages m
            JOIN users u ON m.applicant_id = u.id
            ORDER BY m.created_at DESC";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function updateJobPost($id, $title, $description) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE job_posts SET title = :title, description = :description, updated_at = NOW() WHERE id = :id");
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':id' => $id
    ]);
}

function logActivity($userRole, $action) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO activity_log (user_role, action) VALUES (:user_role, :action)");
    $stmt->execute([
        ':user_role' => $userRole,
        ':action' => $action
    ]);
}

function getMessagesWithSenderName($userId) {
    global $pdo;
    // Fetch the messages along with the sender's name (applicant's username)
    $stmt = $pdo->prepare("SELECT messages.message, messages.created_at, users.username AS sender_name
                           FROM messages
                           JOIN users ON messages.applicant_id = users.id
                           WHERE messages.applicant_id = ?
                           ORDER BY messages.created_at DESC");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllApplicants() {
    global $pdo;
    // Fetch all users with the 'applicant' role
    $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE role = 'applicant'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
