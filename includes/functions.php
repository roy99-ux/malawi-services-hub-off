<?php
//require_once __DIR__ . '/../vendor/autoload.php';

/*function sendRealtimeMessage($channel, $event, $data) {
    $pusher = new Pusher\Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, ['cluster' => PUSHER_CLUSTER]);
    $pusher->trigger($channel, $event, $data);
}*/

function uploadFile($file, $subfolder = '') {
    $targetDir = UPLOAD_DIR . $subfolder;
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
    $fileName = time() . '_' . basename($file['name']);
    $targetPath = $targetDir . $fileName;
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return 'assets/uploads/' . $subfolder . $fileName;
    }
    return false;
}

function sendNotification($userId, $type, $title, $message, $link = null) {
    $stmt = getDb()->prepare("INSERT INTO notifications (user_id, type, title, message, link) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $type, $title, $message, $link]);
    // Optional: send email/SMS if configured
}

function getUnreadMessagesCount($userId) {
    $stmt = getDb()->prepare("SELECT COUNT(*) as cnt FROM messages WHERE receiver_id = ? AND is_read = 0");
    $stmt->execute([$userId]);
    return $stmt->fetch()['cnt'];
}

function getUnreadNotificationsCount($userId) {
    $stmt = getDb()->prepare("SELECT COUNT(*) as cnt FROM notifications WHERE user_id = ? AND is_read = 0");
    $stmt->execute([$userId]);
    return $stmt->fetch()['cnt'];
}

function generateRandomToken() {
    return bin2hex(random_bytes(32));
}

function logActivity($userId, $action, $entityType, $entityId, $details, $ipAddress = null) {
    if (!$ipAddress) {
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    $db = getDb();
    $stmt = $db->prepare("INSERT INTO activity_logs (user_id, action, entity_type, entity_id, details, ip_address, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$userId, $action, $entityType, $entityId, $details, $ipAddress]);
}
?>