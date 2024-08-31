<?php
// Database configuration file

// Database connection parameters
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'user_auth';

// PDO connection string (DSN)
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    // Create a PDO instance and set error mode to exception
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    die("Database connection failed: " . $e->getMessage());
}
