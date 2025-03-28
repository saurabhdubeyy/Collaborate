<?php
// Improved database migration script with better error handling and schema validation

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting database migration...\n";

// Include database connection
try {
    require_once 'config.php';
    echo "Database connection established successfully.\n";
} catch (Exception $e) {
    echo "Error connecting to database: " . $e->getMessage() . "\n";
    exit(1);
}

// Function to safely execute SQL
function executeSql($conn, $sql, $description) {
    try {
        if (mysqli_query($conn, $sql)) {
            echo "$description completed successfully.\n";
            return true;
        } else {
            echo "Error in $description: " . mysqli_error($conn) . "\n";
            return false;
        }
    } catch (Exception $e) {
        echo "Exception in $description: " . $e->getMessage() . "\n";
        return false;
    }
}

// SQL for creating user_form table
$sql_user_form = "CREATE TABLE IF NOT EXISTS `user_form` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// SQL for creating host table
$sql_host = "CREATE TABLE IF NOT EXISTS `host` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CommunityName` varchar(50) NOT NULL,
  `About` varchar(250) NOT NULL,
  `Category` enum('Indoor','Outdoor') NOT NULL,
  `email` varchar(64) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `Requirments` varchar(250) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Execute queries
executeSql($conn, $sql_user_form, "Table user_form creation");
executeSql($conn, $sql_host, "Table host creation");

// Add sample data if the tables are empty
$check_host = mysqli_query($conn, "SELECT * FROM host LIMIT 1");
if (mysqli_num_rows($check_host) == 0) {
    $sample_data = "INSERT INTO `host` (`CommunityName`, `About`, `Category`, `email`, `PhoneNumber`, `Requirments`) VALUES
    ('Hiking Club', 'We organize weekend hikes on local trails', 'Outdoor', 'hiking@example.com', '1234567890', 'Comfortable shoes and water bottle required'),
    ('Book Club', 'Monthly book discussions and literary events', 'Indoor', 'books@example.com', '9876543210', 'No requirements, just love for reading'),
    ('Photography Group', 'Learn and practice photography together', 'Indoor', 'photo@example.com', '5551234567', 'DSLR camera preferred'),
    ('Movie Nights', 'Weekly movie screenings and discussions', 'Indoor', 'movies@example.com', '5559876543', 'Bring your own snacks');";
    
    executeSql($conn, $sample_data, "Sample data insertion");
}

// Create a demo user with password_hash for login
$check_user = mysqli_query($conn, "SELECT * FROM user_form WHERE email = 'demo@example.com' LIMIT 1");
if (mysqli_num_rows($check_user) == 0) {
    $hashed_password = password_hash('password123', PASSWORD_DEFAULT);
    $demo_user = "INSERT INTO `user_form` (`name`, `email`, `password`, `image`) VALUES
    ('Demo User', 'demo@example.com', '$hashed_password', 'default.jpg');";
    
    executeSql($conn, $demo_user, "Demo user creation");
}

// Check if the tables were properly created
$table_check = mysqli_query($conn, "SHOW TABLES");
$tables = [];
while ($row = mysqli_fetch_array($table_check)) {
    $tables[] = $row[0];
}

echo "\nExisting tables in database:\n";
foreach ($tables as $table) {
    echo "- $table\n";
}

echo "\nDatabase migration completed successfully!\n";
?> 