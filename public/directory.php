<?php
require_once('../config/database.php');
require_once('../includes/functions.php');

$page_title = 'ডিরেকটরি';
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>শিল্পী ডিরেকটরি</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .search-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .artists-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .artist-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .artist-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .artist-image {
            width: 100%;
            height: 200px;
            background: #f0f0f0;
            object-fit: cover;
        }
        
        .artist-info {
            padding: 15px;
        }
        
        .artist-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .artist-type {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            margin-bottom: 10px;
        }
        
        .artist-details {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .action-buttons a {
            flex: 1;
            padding: 8px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 12px;
        }
        
        .btn-view {
            background: #17a2b8;
            color: white;
        }
        
        .btn-contact {
            background: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">🎵 নামকীর্তন ও লীলা ডিরেকটরি</div>
            <div class="navbar-menu">
                <a href="index.php">হোম</a>
                <a href="directory.php">ডিরেকটরি</a>
                <a href="../artist/register.php">শিল্পী হিসেবে যোগ দিন</a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="search-container">
            <h2>🔍 শিল্পী খুঁজুন</h2>
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 15px;">
                <input type="text" name="search" placeholder="নাম বা বিশেষত্ব" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                
                <select name="artist_type">
                    <option value="">-- ধরন নির্বাচন করুন --</option>
                    <option value="Kirtan" <?php echo $_GET['artist_type'] == 'Kirtan' ? 'selected' : ''; ?>>নামকীর্তন</option>
                    <option value="Lila" <?php echo $_GET['artist_type'] == 'Lila' ? 'selected' : ''; ?>>লীলা</option>
                    <option value="Both" <?php echo $_GET['artist_type'] == 'Both' ? 'selected' : ''; ?>>উভয়</option>
                </select>
                
                <select name="district">
                    <option value="">-- জেলা নির্বাচন করুন --</option>
                    <?php foreach (getDistricts() as $d): ?>
                        <option value="<?php echo $d; ?>" <?php echo $_GET['district'] == $d ? 'selected' : ''; ?>><?php echo $d; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" class="btn btn-primary">🔍 খুঁজুন</button>
            </form>
        </div>
        
        <?php if (isset($_GET['search']) || isset($_GET['artist_type']) || isset($_GET['district'])): ?>
            <?php
            $filters = [
                'search' => $_GET['search'] ?? '',
                'artist_type' => $_GET['artist_type'] ?? '',
                'district' => $_GET['district'] ?? ''
            ];
            $artists = searchArtists($filters);
            ?>
            
            <div class="artists-grid">
                <?php if (!empty($artists)): ?>
                    <?php foreach ($artists as $artist): ?>
                        <div class="artist-card">
                            <?php if ($artist['photo'] && file_exists('../uploads/artists/' . $artist['photo'])): ?>
                                <img src="<?php echo UPLOAD_URL . 'artists/' . $artist['photo']; ?>" alt="ছবি" class="artist-image">
                            <?php else: ?>
                                <div class="artist-image" style="display: flex; align-items: center; justify-content: center;">ছবি নেই</div>
                            <?php endif; ?>
                            
                            <div class="artist-info">
                                <div class="artist-name"><?php echo $artist['full_name_bn']; ?></div>
                                <span class="artist-type"><?php echo $artist['artist_type']; ?></span>
                                <div class="artist-details">
                                    <p>📍 <?php echo $artist['district']; ?></p>
                                    <p>🎵 <?php echo $artist['specialization'] ?? 'অনির্ধারিত'; ?></p>
                                </div>
                                
                                <div class="action-buttons">
                                    <a href="artist-detail.php?id=<?php echo $artist['artist_id']; ?>" class="btn-view">বিশদ</a>
                                    <a href="contact.php?artist_id=<?php echo $artist['artist_id']; ?>" class="btn-contact">যোগাযোগ</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #999;">
                        কোনো শিল্পী পাওয়া যায়নি। অন্য মানদণ্ড চেষ্টা করুন।
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <footer class="footer">
        <p>&copy; २०२६ নামকীর্তন ও লীলা কর্তনীয় ডিরেকটরি</p>
    </footer>
</body>
</html>
