<?php
require_once('../config/database.php');
require_once('../includes/functions.php');

requireArtistLogin();

$artist_id = $_SESSION['artist_id'];
$artist = getArtistInfo($artist_id);

$success = '';
$error = '';

// Handle profile photo upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photo'])) {
    if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        // Delete old photo if exists
        if ($artist['photo'] && file_exists('../uploads/artists/' . $artist['photo'])) {
            unlink('../uploads/artists/' . $artist['photo']);
        }
        
        // Upload new photo
        $upload_result = uploadFile($_FILES['photo']);
        if ($upload_result['success']) {
            $query = "UPDATE artists SET photo = '{$upload_result['filename']}' WHERE artist_id = $artist_id";
            if ($conn->query($query)) {
                $success = '✅ ছবি আপডেট হয়েছে';
                $artist = getArtistInfo($artist_id);
            }
        } else {
            $error = $upload_result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>আমার প্রোফাইল - ছবি আপডেট</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="navbar">
        <div class="container">
            <div class="navbar-brand">👤 আমার প্রোফাইল</div>
        </div>
    </div>
    
    <div class="container">
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="card">
            <h2>📸 আপনার ছবি আপডেট করুন</h2>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>নতুন ছবি নির্বাচন করুন</label>
                    <input type="file" name="photo" accept="image/*" required>
                    <small>ম্যাক্সিমাম সাইজ: 5MB | ফরম্যাট: JPG, PNG, GIF</small>
                </div>
                
                <button type="submit" class="btn btn-primary">📤 আপলোড করুন</button>
            </form>
            
            <?php if ($artist['photo']): ?>
                <h3 style="margin-top: 30px;">বর্তমান ছবি:</h3>
                <img src="<?php echo UPLOAD_URL . 'artists/' . $artist['photo']; ?>" alt="প্রোফাইল ছবি" style="max-width: 300px; border-radius: 10px; margin-top: 15px;">
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
