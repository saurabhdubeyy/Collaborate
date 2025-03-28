<?php
// Database configuration with improved environment variable handling
// Primary configuration - for Render PostgreSQL
$db_host = getenv('PGHOST') ?: getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('PGUSER') ?: getenv('DB_USER') ?: 'root';
$db_pass = getenv('PGPASSWORD') ?: getenv('DB_PASSWORD') ?: '';
$db_name = getenv('PGDATABASE') ?: getenv('DB_NAME') ?: 'test3';
$db_port = getenv('PGPORT') ?: 5432;

// Connection options
$options = [
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT), // Enable exception throwing
];

// For logging database setup attempts
error_log("Attempting to connect to database at $db_host:$db_port");
error_log("Database credentials: user=$db_user, db=$db_name");

// Create connection with error handling
try {
    // Try to connect
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    
    // Set character set
    if ($conn) {
        mysqli_set_charset($conn, 'utf8mb4');
        error_log("Database connection successful");
    } else {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    // Log error (to file in production)
    error_log("Database connection error: " . $e->getMessage());
    
    // For deployment purposes, don't fail fatally in production
    if (getenv('APP_ENV') === 'production') {
        // Create a dummy connection object for code that expects $conn
        // This prevents fatal errors while maintaining the site structure
        $conn = false;
    } else {
        die("Connection failed: " . $e->getMessage());
    }
}
?>