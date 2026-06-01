<?php
require_once('../config/database.php');
require_once('../includes/functions.php');

requireArtistLogin();

$artist_id = $_SESSION['artist_id'];
$artist = getArtistInfo($artist_id);

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action == 'edit') {
        $full_name_bn = sanitize($_POST['full_name_bn']);
        $full_name_en = sanitize($_POST['full_name_en']);
        $phone = sanitize($_POST['phone']);
        $experience_years = (int)$_POST['experience_years'];
        $specialization = sanitize($_POST['specialization']);
        $bio = sanitize($_POST['bio']);
        $social_facebook = sanitize($_POST['social_facebook']);
        $social_whatsapp = sanitize($_POST['social_whatsapp']);
        $website = sanitize($_POST['website']);
        
        $update_query = "UPDATE artists SET 
            full_name_bn = '$full_name_bn',
            full_name_en = '$full_name_en',
            phone = '$phone',
            experience_years = $experience_years,
            specialization = '$specialization',
            bio = '$bio',
            social_facebook = '$social_facebook',
            social_whatsapp = '$social_whatsapp',
            website = '$website'
            WHERE artist_id = $artist_id";
        
        if ($conn->query($update_query)) {
            $message = '✅ প্রোফাইল সফলভাবে আপডেট হয়েছে';
            $artist = getArtistInfo($artist_id);
        } else {
            $error = 'প্রোফাইল আপডেটে ত্রুটি হয়েছে';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>আমার প্রোফাইল</title>
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-size: 24px;
        }
        
        .logout-btn {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
        }
        
        .logout-btn:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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
        
        .alert-info {
            background-color: #d1ecf1;
            border-color: #17a2b8;
            color: #0c5460;
        }
        
        .profile-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .profile-header {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        
        .profile-photo {
            width: 150px;
            height: 150px;
            background: #f0f0f0;
            border-radius: 10px;
            object-fit: cover;
        }
        
        .profile-info h2 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .profile-info p {
            color: #666;
            margin: 5px 0;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            margin-top: 10px;
        }
        
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .form-section {
            margin-bottom: 25px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 15px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        input[type="text"],
        input[type="tel"],
        input[type="number"],
        textarea {
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
            min-height: 80px;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-save {
            background-color: #667eea;
            color: white;
        }
        
        .btn-save:hover {
            background-color: #5568d3;
        }
        
        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-cancel:hover {
            background-color: #5a6268;
        }
        
        .messages-section {
            margin-top: 20px;
        }
        
        .message-item {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #667eea;
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .message-author {
            font-weight: 600;
            color: #333;
        }
        
        .message-date {
            color: #999;
            font-size: 12px;
        }
        
        .message-text {
            color: #666;
        }
        
        .no-messages {
            text-align: center;
            padding: 30px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div>
                <h1>👤 আমার প্রোফাইল</h1>
                <p>শিল্পী ড্যাশবোর্ড</p>
            </div>
            <a href="logout.php" class="logout-btn">লগআউট</a>
        </div>
    </div>
    
    <div class="container">
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($artist['status'] == 'Pending'): ?>
            <div class="alert alert-info">
                ℹ️ আপনার অ্যাকাউন্ট এখনও এডমিনের অনুমোদনের জন্য অপেক্ষা করছে। অনুমোদিত হওয়ার পরে আপনার প্রোফাইল ডিরেকটরিতে দেখা যাবে।
            </div>
        <?php endif; ?>
        
        <div class="profile-card">
            <div class="profile-header">
                <div>
                    <?php if ($artist['photo'] && file_exists('../uploads/artists/' . $artist['photo'])): ?>
                        <img src="<?php echo UPLOAD_URL . 'artists/' . $artist['photo']; ?>" alt="ছবি" class="profile-photo">
                    <?php else: ?>
                        <div class="profile-photo" style="display: flex; align-items: center; justify-content: center; background: #ddd;">
                            <span style="color: #999;">ছবি নেই</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="profile-info">
                    <h2><?php echo $artist['full_name_bn']; ?></h2>
                    <p><strong><?php echo $artist['full_name_en']; ?></strong></p>
                    <p>📧 <?php echo $artist['email']; ?></p>
                    <p>📱 <?php echo formatPhone($artist['phone']); ?></p>
                    <span class="status-badge <?php echo $artist['status'] == 'Approved' ? 'status-approved' : 'status-pending'; ?>">
                        <?php echo $artist['status'] == 'Approved' ? '✅ অনুমোদিত' : '⏳ অপেক্ষমাণ'; ?>
                    </span>
                </div>
            </div>
            
            <form method="POST">
                <input type="hidden" name="action" value="edit">
                
                <div class="form-section">
                    <div class="section-title">ব্যক্তিগত তথ্য</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>পূর্ণ নাম (বাংলা)</label>
                            <input type="text" name="full_name_bn" value="<?php echo htmlspecialchars($artist['full_name_bn']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>পূর্ণ নাম (ইংরেজি)</label>
                            <input type="text" name="full_name_en" value="<?php echo htmlspecialchars($artist['full_name_en']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>ফোন নম্বর</label>
                            <input type="tel" name="phone" value="<?php echo $artist['phone']; ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <div class="section-title">পেশাদার তথ্য</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>অভিজ্ঞতা (বছর)</label>
                            <input type="number" name="experience_years" value="<?php echo $artist['experience_years']; ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>বিশেষত্ব</label>
                            <input type="text" name="specialization" value="<?php echo htmlspecialchars($artist['specialization']); ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>জীবনী / পরিচয়</label>
                            <textarea name="bio"><?php echo htmlspecialchars($artist['bio']); ?></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <div class="section-title">সোশ্যাল মিডিয়া</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>ফেসবুক প্রোফাইল</label>
                            <input type="text" name="social_facebook" value="<?php echo htmlspecialchars($artist['social_facebook']); ?>">
                        </div>
                        <div class="form-group">
                            <label>হোয়াটসঅ্যাপ নম্বর</label>
                            <input type="tel" name="social_whatsapp" value="<?php echo htmlspecialchars($artist['social_whatsapp']); ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>ওয়েবসাইট</label>
                            <input type="text" name="website" value="<?php echo htmlspecialchars($artist['website']); ?>">
                        </div>
                    </div>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn-save">💾 প্রোফাইল সংরক্ষণ করুন</button>
                    <a href="<?php echo BASE_URL; ?>public/index.php" class="btn-cancel" style="text-decoration: none;">ঘরে ফিরুন</a>
                </div>
            </form>
        </div>
        
        <!-- বার্তা সেকশন -->
        <div class="profile-card">
            <h2>💬 আপনাকে পাঠানো বার্তা</h2>
            
            <?php
            $messages_query = "SELECT * FROM contact_messages WHERE recipient_artist_id = $artist_id ORDER BY created_at DESC LIMIT 10";
            $messages_result = $conn->query($messages_query);
            
            if ($messages_result && $messages_result->num_rows > 0):
                while ($msg = $messages_result->fetch_assoc()):
            ?>
                <div class="message-item">
                    <div class="message-header">
                        <span class="message-author"><?php echo $msg['sender_name']; ?></span>
                        <span class="message-date"><?php echo formatDate($msg['created_at']); ?></span>
                    </div>
                    <p><strong>বিষয়:</strong> <?php echo htmlspecialchars($msg['subject']); ?></p>
                    <p class="message-text"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                    <p><strong>যোগাযোগ:</strong> <?php echo $msg['sender_email']; ?> | <?php echo $msg['sender_phone']; ?></p>
                </div>
            <?php
                endwhile;
            else:
            ?>
                <div class="no-messages">
                    <p>এখনও কোনো বার্তা নেই</p>
                </div>
            <?php
            endif;
            ?>
        </div>
    </div>
</body>
</html>
