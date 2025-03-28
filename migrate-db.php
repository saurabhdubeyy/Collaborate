<?php
// This script runs during deployment to set up the database on Render

// Include database connection
require_once 'config.php';

// SQL for creating user_form table
$sql_user_form = "CREATE TABLE IF NOT EXISTS `user_form` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Execute queries
if (mysqli_query($conn, $sql_user_form)) {
    echo "Table user_form created successfully\n";
} else {
    echo "Error creating table user_form: " . mysqli_error($conn) . "\n";
}

if (mysqli_query($conn, $sql_host)) {
    echo "Table host created successfully\n";
} else {
    echo "Error creating table host: " . mysqli_error($conn) . "\n";
}

// Add sample data if the tables are empty
$check_host = mysqli_query($conn, "SELECT * FROM host LIMIT 1");
if (mysqli_num_rows($check_host) == 0) {
    $sample_data = "INSERT INTO `host` (`CommunityName`, `About`, `Category`, `email`, `PhoneNumber`, `Requirments`) VALUES
    ('Hiking Club', 'We organize weekend hikes on local trails', 'Outdoor', 'hiking@example.com', '1234567890', 'Comfortable shoes and water bottle required'),
    ('Book Club', 'Monthly book discussions and literary events', 'Indoor', 'books@example.com', '9876543210', 'No requirements, just love for reading');";
    
    if (mysqli_query($conn, $sample_data)) {
        echo "Sample data added successfully\n";
    } else {
        echo "Error adding sample data: " . mysqli_error($conn) . "\n";
    }
}

// Create a demo user with password_hash for login
$check_user = mysqli_query($conn, "SELECT * FROM user_form WHERE email = 'demo@example.com' LIMIT 1");
if (mysqli_num_rows($check_user) == 0) {
    $hashed_password = password_hash('password123', PASSWORD_DEFAULT);
    $demo_user = "INSERT INTO `user_form` (`name`, `email`, `password`, `image`) VALUES
    ('Demo User', 'demo@example.com', '$hashed_password', 'default.jpg');";
    
    if (mysqli_query($conn, $demo_user)) {
        echo "Demo user created successfully\n";
    } else {
        echo "Error creating demo user: " . mysqli_error($conn) . "\n";
    }
}

echo "Database migration completed\n";
?> 