<?php
// =====================================================
// Database Configuration
// =====================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'kirtan_lila_db');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");

// Define base URL
define('BASE_URL', 'http://localhost/kirtan-lila-directory/');

// Session timeout (30 minutes)
define('SESSION_TIMEOUT', 1800);

// Upload directory
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/kirtan-lila-directory/uploads/');
define('UPLOAD_URL', BASE_URL . 'uploads/');

// Max file size (5MB)
define('MAX_FILE_SIZE', 5 * 1024 * 1024);

// Allowed file types
define('ALLOWED_TYPES', array('image/jpeg', 'image/png', 'image/gif'));
?>
