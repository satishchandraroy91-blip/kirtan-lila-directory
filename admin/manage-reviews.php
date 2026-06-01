<?php
require_once('../config/database.php');
require_once('../includes/functions.php');

requireAdminLogin();

// Get all reviews
$query = "SELECT r.*, a.full_name_bn FROM reviews r 
          JOIN artists a ON r.artist_id = a.artist_id 
          ORDER BY r.created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পর্যালোচনা ব্যবস্থাপনা</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .nav-menu {
            background: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .nav-menu a {
            padding: 8px 16px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        
        .review-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border-left: 4px solid #ffc107;
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .review-author {
            font-weight: 600;
            color: #333;
        }
        
        .rating {
            color: #ffc107;
            font-size: 18px;
        }
        
        .review-artist {
            font-size: 13px;
            color: #999;
            margin-top: 5px;
        }
        
        .review-text {
            color: #666;
            margin: 15px 0;
        }
        
        .no-reviews {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="max-width: 1000px; margin: 0 auto;">
            <h1>⭐ পর্যালোচনা ব্যবস্থাপনা</h1>
            <p>সকল শিল্পীর পর্যালোচনা দেখুন</p>
        </div>
    </div>
    
    <div class="container">
        <div class="nav-menu">
            <a href="dashboard.php">📊 ড্যাশবোর্ড</a>
            <a href="manage-reviews.php">⭐ পর্যালোচনা</a>
            <a href="logout.php">🚪 লগআউট</a>
        </div>
        
        <?php
        if ($result && $result->num_rows > 0) {
            while ($review = $result->fetch_assoc()) {
        ?>
                <div class="review-card">
                    <div class="review-header">
                        <div>
                            <div class="review-author"><?php echo $review['reviewer_name'] ?? 'অজানা'; ?></div>
                            <div class="review-artist">📌 <?php echo $review['full_name_bn']; ?></div>
                        </div>
                        <div class="rating">
                            <?php 
                            for ($i = 0; $i < $review['rating']; $i++) {
                                echo '⭐';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <p class="review-text"><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                    
                    <div style="font-size: 12px; color: #999;">
                        প্রকাশিত: <?php echo formatDate($review['created_at']); ?>
                    </div>
                </div>
        <?php
            }
        } else {
        ?>
                <div class="no-reviews">
                    <p>কোনো পর্যালোচনা নেই</p>
                </div>
        <?php
        }
        ?>
    </div>
</body>
</html>
