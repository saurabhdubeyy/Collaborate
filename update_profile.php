<?php

include 'config.php';
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
   header('location:login.php');
   exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

   // Check if email already exists for another user
   $check_email = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$update_email' AND id != '$user_id'");
   if(mysqli_num_rows($check_email) > 0){
      $message[] = 'Email already exists!';
   } else {
      mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('query failed');
      $message[] = 'Profile updated successfully!';
   }

   // Password update handling with modern password hashing
   $current_pass = $_POST['update_pass'];
   $new_pass = $_POST['new_pass'];
   $confirm_pass = $_POST['confirm_pass'];

   if(!empty($current_pass) || !empty($new_pass) || !empty($confirm_pass)){
      // Get current password from database
      $select_pass = mysqli_query($conn, "SELECT password FROM `user_form` WHERE id = '$user_id'") or die('query failed');
      $fetch_pass = mysqli_fetch_assoc($select_pass);
      $db_pass = $fetch_pass['password'];
      
      // Check if current password is correct (handling both old md5 and new hash)
      $password_correct = false;
      if(md5($current_pass) === $db_pass){
         $password_correct = true;
      } else if(password_verify($current_pass, $db_pass)){
         $password_correct = true;
      }
      
      if(!$password_correct){
         $message[] = 'Current password is incorrect!';
      } elseif($new_pass != $confirm_pass){
         $message[] = 'Confirm password does not match!';
      } elseif(strlen($new_pass) < 8){
         $message[] = 'Password should be at least 8 characters long!';
      } else{
         // Hash new password
         $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);
         mysqli_query($conn, "UPDATE `user_form` SET password = '$hashed_password' WHERE id = '$user_id'") or die('query failed');
         $message[] = 'Password updated successfully!';
      }
   }

   // Image update with secure unique filename
   if(isset($_FILES['update_image']) && $_FILES['update_image']['size'] > 0){
      $update_image = $_FILES['update_image']['name'];
      $update_image_size = $_FILES['update_image']['size'];
      $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
      
      // Generate unique image name
      $image_ext = pathinfo($update_image, PATHINFO_EXTENSION);
      $update_image_name = uniqid() . '.' . $image_ext;
      $update_image_folder = 'uploaded_img/'.$update_image_name;

      if($update_image_size > 2000000){
         $message[] = 'Image is too large (max 2MB)';
      } else {
         // Get old image to delete
         $select_old_image = mysqli_query($conn, "SELECT image FROM `user_form` WHERE id = '$user_id'");
         $fetch_old_image = mysqli_fetch_assoc($select_old_image);
         
         $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image_name' WHERE id = '$user_id'") or die('query failed');
         
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
            
            // Delete old image if it exists and is not the default
            if($fetch_old_image['image'] != '' && file_exists('uploaded_img/'.$fetch_old_image['image'])){
               unlink('uploaded_img/'.$fetch_old_image['image']);
            }
            
            $message[] = 'Image updated successfully!';
         }
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['image'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="uploaded_img/'.$fetch['image'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>Username:</span>
            <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box" required>
            <span>Email:</span>
            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box" required>
            <span>Update Profile Picture:</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <span>Current Password:</span>
            <input type="password" name="update_pass" placeholder="enter current password" class="box">
            <span>New Password:</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box" pattern=".{8,}" title="Password must be at least 8 characters">
            <span>Confirm Password:</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <input type="submit" value="Update Profile" name="update_profile" class="btn">
      <a href="home.php" class="delete-btn">Go Back</a>
   </form>

</div>

</body>
</html>