<?php
// Database configuration with improved environment variable handling
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'test3';

// Connection options
$options = [
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT), // Enable exception throwing
];

// Create connection with error handling
try {
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    
    // Set character set
    mysqli_set_charset($conn, 'utf8mb4');
    
    // Check connection
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    // Log error (to file in production)
    error_log("Database connection error: " . $e->getMessage());
    
    // Show friendly message in production, detailed in development
    if (getenv('APP_ENV') === 'production') {
        die("Database connection error. Please try again later.");
    } else {
        die("Connection failed: " . $e->getMessage());
    }
}
?>