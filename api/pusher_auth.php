<?php
require_once '../includes/auth.php';
requireLogin();
require_once '../vendor/autoload.php';

$pusher = new Pusher\Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, ['cluster' => PUSHER_CLUSTER]);

$channel_name = $_POST['channel_name'];
$socket_id = $_POST['socket_id'];

// Only allow private-chat-* channels where user is participant
if (preg_match('/^private-chat-(\d+)$/', $channel_name, $matches)) {
    $convId = $matches[1];
    $stmt = getDb()->prepare("SELECT user1_id, user2_id FROM conversations WHERE id = ?");
    $stmt->execute([$convId]);
    $conv = $stmt->fetch();
    if ($conv && ($conv['user1_id'] == $_SESSION['user_id'] || $conv['user2_id'] == $_SESSION['user_id'])) {
        echo $pusher->authorizeChannel($channel_name, $socket_id);
        exit;
    }
}
http_response_code(403);
echo 'Forbidden';