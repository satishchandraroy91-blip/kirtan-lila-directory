<?php
require_once('../config/database.php');
require_once('../includes/functions.php');

$page_title = 'হোম';
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নামকীর্তন ও লীলা কর্তনীয় ডিরেকটরি</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
        }
        
        .navbar-menu {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .navbar-menu a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .navbar-menu a:hover {
            opacity: 0.8;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .main-content {
            min-height: 70vh;
        }
        
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
        }
        
        .hero-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: white;
            color: #667eea;
        }
        
        .btn-primary:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .btn-secondary {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background-color: white;
            color: #667eea;
        }
        
        .features {
            padding: 60px 20px;
            background-color: #f8f9fa;
        }
        
        .features h2 {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
            font-size: 32px;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }
        
        .feature-card h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 24px;
        }
        
        .feature-card p {
            color: #666;
        }
        
        .stats {
            padding: 60px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }
        
        .stat-item h3 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        
        .stat-item p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 36px;
            }
            
            .hero-buttons {
                flex-direction: column;
            }
            
            .navbar-menu {
                flex-direction: column;
                gap: 10px;
            }
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
                <a href="<?php echo BASE_URL; ?>artist/register.php">শিল্পী হিসেবে যোগ দিন</a>
                <a href="<?php echo BASE_URL; ?>admin/login.php">এডমিন লগইন</a>
            </div>
        </div>
    </nav>
    
    <main class="main-content">
        <section class="hero">
            <h1>🎼 নামকীর্তন ও লীলা কর্তনীয় ডিরেকটরি</h1>
            <p>আপনার নিকটবর্তী দক্ষ শিল্পীদের খুঁজুন এবং তাদের সাথে যোগাযোগ করুন</p>
            <div class="hero-buttons">
                <a href="directory.php" class="btn btn-primary">📖 ডিরেকটরি দেখুন</a>
                <a href="<?php echo BASE_URL; ?>artist/register.php" class="btn btn-secondary">➕ শিল্পী হিসেবে যোগ দিন</a>
            </div>
        </section>
        
        <section class="features">
            <h2>আমাদের বৈশিষ্ট্য</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <h3>🎵 সম্পূর্ণ ডিরেকটরি</h3>
                    <p>সারা বাংলাদেশের নামকীর্তন এবং লীলা কর্তনীয়দের বিশাল সংগ্রহ</p>
                </div>
                
                <div class="feature-card">
                    <h3>📍 অবস্থান অনুযায়ী অনুসন্ধান</h3>
                    <p>আপনার এলাকায় শিল্পীদের সহজেই খুঁজে পান</p>
                </div>
                
                <div class="feature-card">
                    <h3>💬 সরাসরি যোগাযোগ</h3>
                    <p>শিল্পীদের সাথে সরাসরি যোগাযোগ করুন এবং পরিষেবা নিন</p>
                </div>
                
                <div class="feature-card">
                    <h3>✅ যাচাইকৃত শিল্পী</h3>
                    <p>সমস্ত শিল্পী এডমিন দ্বারা যাচাই এবং অনুমোদিত</p>
                </div>
                
                <div class="feature-card">
                    <h3>📱 সহজ নিবন্ধন</h3>
                    <p>শিল্পীরা সহজেই তাদের প্রোফাইল তৈরি এবং পরিচালনা করতে পারেন</p>
                </div>
                
                <div class="feature-card">
                    <h3>⭐ পর্যালোচনা ও মূল্যায়ন</h3>
                    <p>অন্যদের অভিজ্ঞতা এবং মতামত পড়ুন</p>
                </div>
            </div>
        </section>
        
        <section class="stats">
            <div class="stats-grid">
                <?php
                $total_artists = $conn->query("SELECT COUNT(*) as count FROM artists WHERE status = 'Approved'")->fetch_assoc()['count'];
                $total_messages = $conn->query("SELECT COUNT(*) as count FROM contact_messages")->fetch_assoc()['count'];
                $total_reviews = $conn->query("SELECT COUNT(*) as count FROM reviews")->fetch_assoc()['count'];
                ?>
                
                <div class="stat-item">
                    <h3><?php echo $total_artists; ?></h3>
                    <p>যাচাইকৃত শিল্পী</p>
                </div>
                
                <div class="stat-item">
                    <h3><?php echo count(getDistricts()); ?></h3>
                    <p>জেলায় উপস্থিত</p>
                </div>
                
                <div class="stat-item">
                    <h3><?php echo $total_messages; ?></h3>
                    <p>মোট যোগাযোগ</p>
                </div>
                
                <div class="stat-item">
                    <h3><?php echo $total_reviews; ?></h3>
                    <p>পর্যালোচনা</p>
                </div>
            </div>
        </section>
    </main>
    
    <footer class="footer">
        <p>&copy; ২০২৬ নামকীর্তন ও লীলা কর্তনীয় ডিরেকটরি। সর্বাধিকার সংরক্ষিত।</p>
        <p>যোগাযোগ: info@kirtanlila.com | ফোন: +880-1700-000000</p>
    </footer>
</body>
</html>
