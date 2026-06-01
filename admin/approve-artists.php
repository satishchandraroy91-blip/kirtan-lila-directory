<?php
require_once('../config/database.php');
require_once('../includes/functions.php');

$success = '';
$error = '';

// Handle different admin actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action == 'approve') {
        $artist_id = (int)$_POST['artist_id'];
        $reason = sanitize($_POST['reason'] ?? '');
        
        $query = "UPDATE artists SET status = 'Approved' WHERE artist_id = $artist_id";
        if ($conn->query($query)) {
            logAction($artist_id, $_SESSION['admin_id'], 'Approved', $reason);
            $success = '✅ শিল্পী সফলভাবে অনুমোদিত হয়েছেন';
        }
    } elseif ($action == 'reject') {
        $artist_id = (int)$_POST['artist_id'];
        $reason = sanitize($_POST['reason'] ?? '');
        
        $query = "UPDATE artists SET status = 'Rejected' WHERE artist_id = $artist_id";
        if ($conn->query($query)) {
            logAction($artist_id, $_SESSION['admin_id'], 'Rejected', $reason);
            $success = '❌ আবেদন প্রত্যাখ্যান করা হয়েছে';
        }
    }
}

// Get all pending artists for approval page
$pending_query = "SELECT * FROM artists WHERE status = 'Pending' ORDER BY created_at ASC";
$pending_result = $conn->query($pending_query);
$pending_count = $pending_result ? $pending_result->num_rows : 0;
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>শিল্পী অনুমোদন পেজ</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="navbar">
        <div class="container">
            <div class="navbar-brand">🎵 নামকীর্তন ও লীলা ডিরেকটরি - এডমিন</div>
        </div>
    </div>
    
    <div class="container">
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <h2>✅ অপেক্ষমাণ শিল্পী অনুমোদন (<?php echo $pending_count; ?>)</h2>
        
        <?php if ($pending_count > 0): ?>
            <?php while ($artist = $pending_result->fetch_assoc()): ?>
                <div class="card">
                    <h3><?php echo $artist['full_name_bn']; ?> (<?php echo $artist['full_name_en']; ?>)</h3>
                    <p><strong>ইমেইল:</strong> <?php echo $artist['email']; ?></p>
                    <p><strong>ফোন:</strong> <?php echo formatPhone($artist['phone']); ?></p>
                    <p><strong>ধরন:</strong> <?php echo $artist['artist_type']; ?></p>
                    <p><strong>জেলা:</strong> <?php echo $artist['district']; ?></p>
                    <p><strong>বিশেষত্ব:</strong> <?php echo $artist['specialization'] ?? 'অনির্ধারিত'; ?></p>
                    <p><strong>জীবনী:</strong> <?php echo substr($artist['bio'], 0, 100) . '...'; ?></p>
                    
                    <form method="POST" style="margin-top: 15px;">
                        <input type="hidden" name="artist_id" value="<?php echo $artist['artist_id']; ?>">
                        <div class="form-group">
                            <label>মন্তব্য</label>
                            <textarea name="reason" placeholder="অনুমোদন বা প্রত্যাখ্যানের কারণ লিখুন..."></textarea>
                        </div>
                        <button type="submit" name="action" value="approve" class="btn btn-success">✓ অনুমোদন করুন</button>
                        <button type="submit" name="action" value="reject" class="btn btn-danger">✕ প্রত্যাখ্যান করুন</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info">কোনো অনুমোদনের জন্য অপেক্ষমাণ আবেদন নেই</div>
        <?php endif; ?>
    </div>
</body>
</html>
