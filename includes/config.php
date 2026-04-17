<?php
// PayChangu
define('PAYCHANGU_STORE_ID', 'YOUR_STORE_ID');
define('PAYCHANGU_STORE_KEY', 'YOUR_STORE_KEY');
define('PAYCHANGU_API_URL', 'https://api.paychangu.com/v1'); // or test URL

// Pusher (real-time)
define('PUSHER_APP_ID', 'YOUR_APP_ID');
define('PUSHER_APP_KEY', 'YOUR_APP_KEY');
define('PUSHER_APP_SECRET', 'YOUR_APP_SECRET');
define('PUSHER_CLUSTER', 'mt1');

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Africa/Blantyre');

define('BASE_URL', 'http://localhost/malawi-services-hub-off/');
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');
define('MAX_FILE_SIZE', 50 * 1024 * 1024); // 50MB
?>