<?php

include 'config.php';
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
   header('location:login.php');
   exit();
}

$user_id = $_SESSION['user_id'];

// Handle logout
if(isset($_GET['logout'])){
   // Clear all session data
   session_unset();
   session_destroy();
   // Set cookie expiration in the past to clear cookies
   setcookie(session_name(), '', time() - 3600, '/');
   header('location:login.php');
   exit();
}

// Get user data
$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
if(mysqli_num_rows($select) > 0){
   $fetch = mysqli_fetch_assoc($select);
} else {
   // If user doesn't exist, log them out
   session_unset();
   session_destroy();
   header('location:login.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile | Collaborate</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css" />
    <style>
      .profile-stats {
        display: flex;
        justify-content: space-around;
        margin: 20px 0;
        padding: 15px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
      }
      .stat {
        text-align: center;
      }
      .stat-count {
        font-size: 24px;
        font-weight: bold;
      }
      .stat-label {
        font-size: 14px;
        color: #ccc;
      }
      .profile-nav {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
      }
      .last-login {
        text-align: center;
        margin-top: 15px;
        font-size: 14px;
        color: #ccc;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="profile">
        <?php
        if($fetch['image'] == ''){
          echo '<img src="images/default-avatar.png" alt="Profile Image" />';
        } else {
          echo '<img src="uploaded_img/'.$fetch['image'].'" alt="Profile Image" />';
        }
        ?>
        <h3><?php echo htmlspecialchars($fetch['name']); ?></h3>
        <p><?php echo htmlspecialchars($fetch['email']); ?></p>
        
        <div class="profile-stats">
          <div class="stat">
            <div class="stat-count">0</div>
            <div class="stat-label">Communities</div>
          </div>
          <div class="stat">
            <div class="stat-count">0</div>
            <div class="stat-label">Activities</div>
          </div>
          <div class="stat">
            <div class="stat-count">0</div>
            <div class="stat-label">Connections</div>
          </div>
        </div>
        
        <div class="profile-nav">
          <a href="update_profile.php" class="btn">Update Profile</a>
          <a href="get1.php" class="btn">My Communities</a>
          <a href="index.php" class="btn">Homepage</a>
          <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">Logout</a>
        </div>
        
        <div class="last-login">
          Last login: <?php echo date('F j, Y, g:i a'); ?>
        </div>
      </div>
    </div>
  </body>
</html>
