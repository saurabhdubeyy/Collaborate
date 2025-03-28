<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = $_POST['password']; // Plain password from form

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      // Check if old MD5 password exists (for backward compatibility)
      if($row['password'] == md5($pass)){
         // Update to new password hash for better security
         $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
         mysqli_query($conn, "UPDATE `user_form` SET password = '$hashed_password' WHERE id = '{$row['id']}'");
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');
      }
      // Check if password matches using modern hashing
      else if(password_verify($pass, $row['password'])){
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');
      }
      else{
         $message[] = 'incorrect email or password!';
      }
   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Login To Collaborate</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="email" name="email" placeholder="enter email" class="box" required>
      <input type="password" name="password" placeholder="enter password" class="box" required>
      <input type="submit" name="submit" value="login now" class="btn">
      <p>don't have an account? <a href="register.php">Register now.</a></p>
   </form>

</div>

</body>
</html>