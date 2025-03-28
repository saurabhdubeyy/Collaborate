<?php
// Include session management
include 'config.php';
session_start();

// Set default category filter
$category_filter = isset($_GET['category']) ? $_GET['category'] : 'all';
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Database connection already established via config.php

// Prepare query based on filters
$sql = "SELECT id, CommunityName, About, Category, email, PhoneNumber, Requirments FROM host";
$where_conditions = [];

if ($category_filter != 'all') {
    $where_conditions[] = "Category = '$category_filter'";
}

if (!empty($search_term)) {
    $search_term = mysqli_real_escape_string($conn, $search_term);
    $where_conditions[] = "(CommunityName LIKE '%$search_term%' OR About LIKE '%$search_term%')";
}

if (!empty($where_conditions)) {
    $sql .= " WHERE " . implode(" AND ", $where_conditions);
}

$sql .= " ORDER BY id DESC";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communities | Collaborate</title>
    <link rel="stylesheet" href="style1.css">
    <style>
        .communities-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .page-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .page-header p {
            color: #666;
            font-size: 16px;
        }
        
        .filter-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        .filter-buttons {
            display: flex;
            gap: 10px;
        }
        
        .filter-btn {
            padding: 8px 16px;
            background-color: #ddd;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            color: #333;
            transition: background-color 0.3s;
        }
        
        .filter-btn.active {
            background-color: #4a90e2;
            color: white;
        }
        
        .search-box {
            display: flex;
            gap: 10px;
        }
        
        .search-input {
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            min-width: 250px;
        }
        
        .search-btn {
            padding: 8px 16px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .communities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }
        
        .community-card {
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
            min-height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .community-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .outdoor-card {
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("outdoor.png");
            color: white;
        }
        
        .indoor-card {
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("indoor.png");
            color: white;
        }
        
        .card-header {
            margin-bottom: 15px;
        }
        
        .card-title {
            font-size: 22px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .card-category {
            display: inline-block;
            padding: 4px 8px;
            background-color: #4a90e2;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            margin-bottom: 10px;
        }
        
        .card-body {
            margin-bottom: 15px;
        }
        
        .card-footer {
            margin-top: auto;
        }
        
        .contact-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .contact-btn:hover {
            background-color: #3a7bc8;
        }
        
        .no-communities {
            text-align: center;
            padding: 40px;
            font-size: 18px;
            color: #666;
        }
        
        .navigation-bar {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .filter-section {
                flex-direction: column;
                gap: 15px;
            }
            
            .communities-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="communities-container">
        <div class="navigation-bar">
            <a href="index.php" class="btn">Home</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="home.php" class="btn">My Profile</a>
            <?php else: ?>
                <a href="login.php" class="btn">Login</a>
            <?php endif; ?>
            <a href="new/host.php" class="btn">Host Community</a>
        </div>
        
        <div class="page-header">
            <h1>Discover Communities</h1>
            <p>Find and join communities that match your interests</p>
        </div>
        
        <div class="filter-section">
            <div class="filter-buttons">
                <a href="get1.php?category=all<?php echo !empty($search_term) ? '&search=' . urlencode($search_term) : ''; ?>" class="filter-btn <?php echo $category_filter == 'all' ? 'active' : ''; ?>">All</a>
                <a href="get1.php?category=Indoor<?php echo !empty($search_term) ? '&search=' . urlencode($search_term) : ''; ?>" class="filter-btn <?php echo $category_filter == 'Indoor' ? 'active' : ''; ?>">Indoor</a>
                <a href="get1.php?category=Outdoor<?php echo !empty($search_term) ? '&search=' . urlencode($search_term) : ''; ?>" class="filter-btn <?php echo $category_filter == 'Outdoor' ? 'active' : ''; ?>">Outdoor</a>
            </div>
            
            <form class="search-box" method="GET" action="get1.php">
                <input type="hidden" name="category" value="<?php echo $category_filter; ?>">
                <input type="text" name="search" class="search-input" placeholder="Search communities..." value="<?php echo htmlspecialchars($search_term); ?>">
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>
        
        <div class="communities-grid">
            <?php
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $card_class = $row["Category"] === "Outdoor" ? "outdoor-card" : "indoor-card";
                    ?>
                    <div class="community-card <?php echo $card_class; ?>">
                        <div class="card-header">
                            <div class="card-category"><?php echo htmlspecialchars($row["Category"]); ?></div>
                            <h2 class="card-title"><?php echo htmlspecialchars($row["CommunityName"]); ?></h2>
                        </div>
                        
                        <div class="card-body">
                            <p><?php echo htmlspecialchars($row["About"]); ?></p>
                            <p><strong>Requirements:</strong> <?php echo htmlspecialchars($row["Requirments"]); ?></p>
                        </div>
                        
                        <div class="card-footer">
                            <a href="mailto:<?php echo htmlspecialchars($row["email"]); ?>" class="contact-btn">Contact</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="no-communities">No communities found. Why not <a href="new/host.php">create one</a>?</div>';
            }
            ?>
        </div>
    </div>
    
    <footer class="footer">
        <div class="copy">© 2023 Collaborate</div>
        <div class="bottom-links">
            <div class="links">
                <span>More Info</span>
                <a href="#">About us</a>
                <a href="#">Contact us</a>
                <a href="#">Privacy Policy</a>
            </div>
            <div class="links">
                <span>Social Links</span>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>
