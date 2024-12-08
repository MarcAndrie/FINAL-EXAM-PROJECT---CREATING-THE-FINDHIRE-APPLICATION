<?php
session_start();
require_once 'dbConfig.php';

// Check if user is logged in
function checkAuth() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'HR') {
        header('Location: login.php');
        exit();
    }
}

// Login function
function login($username, $password) {
    global $pdo;
    $sql = "SELECT * FROM users WHERE username = :username AND password = MD5(:password) AND role = 'HR'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username, ':password' => $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];
        return true;
    }
    return false;
}
?>
