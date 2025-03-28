<?php
// Include session management
include '../config.php';
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
   header('location:../login.php');
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
        * {
            margin: 0;
            padding: 0;
            font-family: verdana;

        }

        .container {
            width: 100%;
            height: 100vh;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), #25232380), url(walpape2.jpg);
            background-size: cover;
            background-position: center;
            padding-left: 8%;
            padding-right: 8%;
            box-sizing: border-box;
        }

        .navbar {
            width: 100%;
            height: 12%;
            display: flex;
            align-items: center;
        }

        .logo {
            width: 100px;
            cursor: pointer;
        }

        .menu-icon {
            width: 30px;
            cursor: pointer;
            display: none;
            margin: 40px;
        }

        nav {
            flex: 1;
            text-align: right;
        }

        nav ul li {
            list-style: none;
            display: inline-block;
            margin-left: 60px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 13px;
        }

        .row {

            height: 88%;
            display: flex;
            align-items: center;

        }

        .col {
            width: 50%;
            padding-left: 5%;
        }

        h1 {
            color: rgb(0, 0, 0);
            font-size: 50px;
        }

        h3 {
            color: rgb(14, 13, 13);
            font-size: 30px;
            margin-top: 20px;
        }

        p {
            color: rgb(0, 0, 0);
            font-size: 20px;
            margin-top: 20px;
        }
        

        button {
            width: 180px;
            color: #000;
            background: #fff;
            border-radius: 20px;
            border: 0;
            padding: 12px 0;
            outline: none;
            
            margin-top: 30px;
            font-size: 12px;
            
            
        }
        .card{
            width: 200px;
            height: 230px;
            display: inline-block;
            color: rgb(247, 245, 241);font-size: 20px;

            border-radius: 10px;
            padding: 15px 25px;
            box-sizing: border-box;
            margin: 10px 15px;
            background-position:center ;
            background-size: cover;
            cursor: pointer;
            transition: 0.5s;
        }
        .card1{
            background-image: url(bnajare.jfif);
        }
        .card2{
            background-image: url(diidkle.jfif);
            
        }
        .card3{
            background-image: url(nba2.jfif);
        }
        .card4{
            background-image: url(football.jfif);
        }
        .card:hover{
            transform: scale(1.1);
        }
        h5{
            color: #fff;
            text-shadow: 5px 5px 5px #999;
        }
        .card p{
            color: rgb(255, 255, 255);
            text-shadow: 5px 5px 5px #999;
            
            font-size: 16px;
        }

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
    <div class="container">
        <div class="navbar">
            <img src="logo3.jfif" class="logo">
            <nav>
                <ul id="MenuItems">
                    <li><a href="/../../index.php">Home</a></li>
                    <li><a href="../get1.php">Join</a></li>
                </ul>
            </nav>
            <img src="menu.png" class="menu-icon">


        </div>
        <div class="row">
            <div class="col">
                <h1>Get the best talent with proof of work.</h1>
                <h3>An easier way to hire - Post a gig in 60 seconds.</h3>
                <p>Hire from the biggest pre-screened talent pool in the country in 15 minutes.

                </p>
                <a href="../host.php">
                    <button>Host</button>
                  </a>

            </div>
            
            <div class="col">
                <div class="card card1">
                    <h5>Banjare</h5>
                    <p>Break ur limits!
                        -Trek together- </p>
                </div>
                <div class="card card2">
                    <h5>Tangy Doodle</h5>
                    <p>Doodle? This is the Perfect place </p>
                </div>
                <div class="card card3">
                    <h5>NBA Club</h5>
                    <p>Intrested in basketball. Join Us.</p>
                </div>
                <div class="card card4">
                    <h5>Football Club</h5>
                    <p>Vamos. 
                        What arrre you wating for!!</p>
                </div>
        </div>
    </div>

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