<?php
require_once('../config/database.php');
require_once('../includes/functions.php');

requireAdminLogin();

// Get messages
$query = "SELECT cm.*, a.full_name_bn FROM contact_messages cm 
          LEFT JOIN artists a ON cm.recipient_artist_id = a.artist_id 
          ORDER BY cm.created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>বার্তা ব্যবস্থাপনা</title>
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
        
        .message-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .message-sender {
            font-weight: 600;
            color: #333;
        }
        
        .message-date {
            color: #999;
            font-size: 13px;
        }
        
        .message-content {
            margin: 15px 0;
            color: #666;
        }
        
        .message-subject {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .message-footer {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            font-size: 13px;
            color: #666;
        }
        
        .no-messages {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="max-width: 1000px; margin: 0 auto;">
            <h1>💬 বার্তা ব্যবস্থাপনা</h1>
            <p>সকল যোগাযোগ বার্তা দেখুন</p>
        </div>
    </div>
    
    <div class="container">
        <div class="nav-menu">
            <a href="dashboard.php">📊 ড্যাশবোর্ড</a>
            <a href="approve-artists.php">✅ শিল্পী অনুমোদন</a>
            <a href="manage-messages.php">💬 বার্তা</a>
            <a href="logout.php">🚪 লগআউট</a>
        </div>
        
        <?php
        if ($result && $result->num_rows > 0) {
            while ($msg = $result->fetch_assoc()) {
        ?>
                <div class="message-card">
                    <div class="message-header">
                        <div>
                            <div class="message-sender"><?php echo $msg['sender_name']; ?></div>
                            <div class="message-date"><?php echo formatDate($msg['created_at']); ?></div>
                        </div>
                    </div>
                    
                    <div class="message-content">
                        <div class="message-subject">বিষয়: <?php echo htmlspecialchars($msg['subject']); ?></div>
                        <p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                    </div>
                    
                    <div class="message-footer">
                        <p><strong>পাঠানো হয়েছে:</strong> <?php echo $msg['full_name_bn'] ?? 'সরাসরি'; ?></p>
                        <p><strong>ইমেইল:</strong> <?php echo $msg['sender_email']; ?></p>
                        <p><strong>ফোন:</strong> <?php echo $msg['sender_phone']; ?></p>
                    </div>
                </div>
        <?php
            }
        } else {
        ?>
                <div class="no-messages">
                    <p>কোনো বার্তা নেই</p>
                </div>
        <?php
        }
        ?>
    </div>
</body>
</html>
