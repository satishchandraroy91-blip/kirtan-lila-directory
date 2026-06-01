<?php
require_once('../config/database.php');
require_once('../includes/functions.php');

$success = '';
$error = '';
$artist_id = $_GET['artist_id'] ?? '';

if (empty($artist_id)) {
    header("Location: directory.php");
    exit();
}

// Check if artist exists
$artist_query = "SELECT full_name_bn, email FROM artists WHERE artist_id = $artist_id AND status = 'Approved'";
$artist_result = $conn->query($artist_query);

if (!$artist_result || $artist_result->num_rows == 0) {
    header("Location: directory.php");
    exit();
}

$artist = $artist_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sender_name = sanitize($_POST['sender_name']);
    $sender_email = sanitize($_POST['sender_email']);
    $sender_phone = sanitize($_POST['sender_phone']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    
    if (empty($sender_name) || empty($sender_email) || empty($subject) || empty($message)) {
        $error = 'অনুগ্রহ করে সমস্ত প্রয়োজনীয় ফিল্ড পূরণ করুন';
    } elseif (!isValidEmail($sender_email)) {
        $error = 'অনুগ্রহ করে একটি বৈধ ইমেইল প্রবেশ করুন';
    } else {
        $query = "INSERT INTO contact_messages (sender_name, sender_email, sender_phone, recipient_artist_id, subject, message) 
                  VALUES ('$sender_name', '$sender_email', '$sender_phone', $artist_id, '$subject', '$message')";
        
        if ($conn->query($query)) {
            $success = '✅ আপনার বার্তা সফলভাবে পাঠানো হয়েছে। শীঘ্রই যোগাযোগ করা হবে।';
            $_POST = []; // Clear form
        } else {
            $error = 'বার্তা পাঠাতে ত্রুটি হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>যোগাযোগ করুন</title>
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
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 0;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .navbar-menu {
            display: flex;
            gap: 20px;
            margin-top: 15px;
        }
        
        .navbar-menu a {
            color: white;
            text-decoration: none;
            font-weight: 600;
        }
        
        .back-btn {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
        }
        
        .contact-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }
        
        .contact-form h2 {
            color: #333;
            margin-bottom: 10px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        .artist-info {
            background-color: #f0f0ff;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #667eea;
        }
        
        .artist-info p {
            margin: 5px 0;
            color: #333;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .required::after {
            content: " *";
            color: red;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
            font-size: 14px;
        }
        
        input:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        
        textarea {
            resize: vertical;
            min-height: 150px;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        button:hover {
            background-color: #5568d3;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
        }
        
        .alert-error {
            background-color: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }
        
        .footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div style="font-size: 24px; font-weight: bold;">🎵 নামকীর্তন ও লীলা ডিরেকটরি</div>
            <div class="navbar-menu">
                <a href="<?php echo BASE_URL; ?>public/index.php">হোম</a>
                <a href="directory.php">ডিরেকটরি</a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <a href="artist-detail.php?id=<?php echo $artist_id; ?>" class="back-btn">← ফিরুন</a>
        
        <div class="contact-form">
            <h2>💬 যোগাযোগ করুন</h2>
            
            <div class="artist-info">
                <p><strong>📞 শিল্পীর নাম:</strong> <?php echo $artist['full_name_bn']; ?></p>
                <p><strong>📧 ইমেইল:</strong> <?php echo $artist['email']; ?></p>
            </div>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="sender_name" class="required">আপনার নাম</label>
                    <input type="text" id="sender_name" name="sender_name" required value="<?php echo htmlspecialchars($_POST['sender_name'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="sender_email" class="required">আপনার ইমেইল</label>
                    <input type="email" id="sender_email" name="sender_email" required value="<?php echo htmlspecialchars($_POST['sender_email'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="sender_phone">আপনার ফোন নম্বর</label>
                    <input type="tel" id="sender_phone" name="sender_phone" value="<?php echo htmlspecialchars($_POST['sender_phone'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="subject" class="required">বিষয়</label>
                    <input type="text" id="subject" name="subject" required placeholder="যোগাযোগের বিষয় লিখুন" value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="message" class="required">বার্তা</label>
                    <textarea id="message" name="message" required placeholder="আপনার বার্তা এখানে লিখুন..."><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                </div>
                
                <button type="submit">📨 বার্তা পাঠান</button>
            </form>
        </div>
    </div>
    
    <footer class="footer">
        <p>&copy; २०२६ নামকীর্তন ও লীলা কর্তনীয় ডিরেকটরি। সর্বাধিকার সংরক্ষিত।</p>
    </footer>
</body>
</html>
