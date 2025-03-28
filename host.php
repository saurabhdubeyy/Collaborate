<?php
// Include session management
include 'config.php';
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
   header('location:login.php');
   exit();
}

// Show success message if available
$success_message = '';
if(isset($_GET['success']) && $_GET['success'] == 1) {
    $success_message = 'Community created successfully!';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Community | Collaborate</title>
    <link rel="stylesheet" href="../style1.css">
    <style>
      .host-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 30px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      }
      
      .host-form {
        margin-top: 20px;
      }
      
      .form-group {
        margin-bottom: 20px;
      }
      
      .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #444;
      }
      
      .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.8);
        color: #333;
      }
      
      .radio-options {
        display: flex;
        gap: 20px;
      }
      
      .radio-option {
        display: flex;
        align-items: center;
        gap: 5px;
      }
      
      .btn-submit {
        padding: 12px 24px;
        background-color: #4a90e2;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-weight: bold;
      }
      
      .btn-submit:hover {
        background-color: #3a7bc8;
      }
      
      .header-section {
        text-align: center;
        margin-bottom: 30px;
      }
      
      .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 20px;
      }
      
      .category-icons {
        display: flex;
        gap: 20px;
        margin-top: 10px;
      }
      
      .category-icon {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.2s;
      }
      
      .category-icon:hover {
        background-color: rgba(255, 255, 255, 0.1);
      }
      
      .category-icon img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
      }
      
      .navigation {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
      }
    </style>
  </head>
  <body>
    <div class="host-container">
      <div class="header-section">
        <h1>Host Your Community</h1>
        <p>Create a community for others to join and collaborate with you</p>
      </div>
      
      <?php if(!empty($success_message)): ?>
      <div class="success-message">
        <?php echo $success_message; ?>
      </div>
      <?php endif; ?>
      
      <form action="../connect.php" method="post" class="host-form">
        <div class="form-group">
          <label for="CommunityName">Community Name</label>
          <input
            type="text"
            class="form-control"
            id="CommunityName"
            name="CommunityName"
            placeholder="E.g., Hiking Enthusiasts"
            required
          />
        </div>
        
        <div class="form-group">
          <label for="About">About Your Community</label>
          <textarea
            class="form-control"
            id="About"
            name="About"
            rows="3"
            placeholder="Describe what your community is about..."
            required
          ></textarea>
        </div>
        
        <div class="form-group">
          <label>Category</label>
          <div class="category-icons">
            <div class="category-icon" onclick="selectCategory('Indoor')">
              <img src="../indoor.png" alt="Indoor" />
              <div class="radio-option">
                <input
                  type="radio"
                  name="Category"
                  value="Indoor"
                  id="Indoor"
                  required
                />
                <label for="Indoor">Indoor</label>
              </div>
            </div>
            
            <div class="category-icon" onclick="selectCategory('Outdoor')">
              <img src="../outdoor.png" alt="Outdoor" />
              <div class="radio-option">
                <input
                  type="radio"
                  name="Category"
                  value="Outdoor"
                  id="Outdoor"
                />
                <label for="Outdoor">Outdoor</label>
              </div>
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <label for="email">Contact Email</label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            placeholder="Your contact email"
            required
          />
        </div>
        
        <div class="form-group">
          <label for="PhoneNumber">Phone Number</label>
          <input
            type="tel"
            class="form-control"
            id="PhoneNumber"
            name="PhoneNumber"
            placeholder="Your phone number"
            pattern="[0-9]{10}"
            title="Please enter a valid 10-digit phone number"
            required
          />
        </div>
        
        <div class="form-group">
          <label for="Requirments">Requirements</label>
          <textarea
            class="form-control"
            id="Requirments"
            name="Requirments"
            rows="3"
            placeholder="Any specific requirements for joining..."
            required
          ></textarea>
        </div>
        
        <button type="submit" class="btn-submit">Create Community</button>
        
        <div class="navigation">
          <a href="../index.php" class="btn">Back to Home</a>
          <a href="../get1.php" class="btn">View Communities</a>
        </div>
      </form>
    </div>
    
    <script>
      function selectCategory(category) {
        document.getElementById(category).checked = true;
      }
    </script>
  </body>
</html>