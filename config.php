<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'traveldb');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// Establish a database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect. " . $e->getMessage());
}
?>
