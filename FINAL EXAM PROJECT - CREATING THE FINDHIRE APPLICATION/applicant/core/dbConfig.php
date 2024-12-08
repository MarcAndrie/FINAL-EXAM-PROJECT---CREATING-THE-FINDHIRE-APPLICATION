<?php
$host = 'localhost';  // Database host
$dbname = 'findhire'; // Your database name
$username = 'root';   // Your MySQL username
$password = '';       // Your MySQL password (if any)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
