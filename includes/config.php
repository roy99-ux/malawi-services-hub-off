<?php
// PayChangu
define('PAYCHANGU_STORE_ID', 'pub-test-L3S2JjdWc0nDz1wJxSXv2UlLdYrqPCT5');
define('PAYCHANGU_STORE_KEY', 'sec-test-d0L8BN0fYzB0GsKA3dPI0uUWJb5kZ0gM');
define('PAYCHANGU_API_URL', 'https://api.paychangu.com/v1'); // or test URL

// Pusher (real-time)
define('PUSHER_APP_ID', '2145283');
define('PUSHER_APP_KEY', '17f79a983a289582fc11');
define('PUSHER_APP_SECRET', 'fccba482b2a18c340f65');
define('PUSHER_CLUSTER', 'ap2');

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Africa/Blantyre');

define('BASE_URL', 'http://localhost/malawi-services-hub-off/');
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');
define('MAX_FILE_SIZE', 50 * 1024 * 1024); // 50MB
?>