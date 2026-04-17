<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
header('Content-Type: application/json');

$user = getCurrentUser();
if(!$user) { echo json_encode(['error'=>'Unauthenticated']); exit; }

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if($action == 'send') {
    $receiverId = $_POST['receiver_id'];
    $message = trim($_POST['message']);
    if(!$message) exit(json_encode(['error'=>'Empty message']));
    // Get or create conversation
    $convStmt = getDb()->prepare("SELECT id FROM conversations WHERE (user1_id=? AND user2_id=?) OR (user1_id=? AND user2_id=?)");
    $convStmt->execute([$user['id'], $receiverId, $receiverId, $user['id']]);
    $conv = $convStmt->fetch();
    if(!$conv) {
        getDb()->prepare("INSERT INTO conversations (user1_id, user2_id, last_message_time) VALUES (?,?, NOW())")->execute([$user['id'], $receiverId]);
        $convId = getDb()->lastInsertId();
    } else $convId = $conv['id'];
    // Insert message
    $stmt = getDb()->prepare("INSERT INTO messages (conversation_id, sender_id, receiver_id, message) VALUES (?,?,?,?)");
    $stmt->execute([$convId, $user['id'], $receiverId, $message]);
    // Update conversation last message
    getDb()->prepare("UPDATE conversations SET last_message=?, last_message_time=NOW() WHERE id=?")->execute([$message, $convId]);
    sendNotification($receiverId, 'message', 'New message from '.$user['name'], $message, BASE_URL.'messaging.php?conv='.$convId);
    echo json_encode(['success'=>true]);
}
elseif($action == 'fetch') {
    $otherUserId = $_GET['with'];
    $stmt = getDb()->prepare("SELECT m.*, u.name as sender_name FROM messages m JOIN users u ON m.sender_id=u.id WHERE (sender_id=? AND receiver_id=?) OR (sender_id=? AND receiver_id=?) ORDER BY m.created_at ASC");
    $stmt->execute([$user['id'], $otherUserId, $otherUserId, $user['id']]);
    $messages = $stmt->fetchAll();
    // Mark as read
    getDb()->prepare("UPDATE messages SET is_read=1 WHERE receiver_id=? AND sender_id=?")->execute([$user['id'], $otherUserId]);
    echo json_encode($messages);
}
elseif($action == 'suggestions') {
    $suggestions = ["Get a quote", "How much do you charge?", "Where are you located?", "When are you available?", "Can you provide references?"];
    echo json_encode($suggestions);
}

elseif($action == 'send') {
    $receiverId = $_POST['receiver_id'];
    $message = trim($_POST['message']);
    if(!$message) exit(json_encode(['error'=>'Empty message']));
    // Get or create conversation
    $convStmt = getDb()->prepare("SELECT id FROM conversations WHERE (user1_id=? AND user2_id=?) OR (user1_id=? AND user2_id=?)");
    $convStmt->execute([$user['id'], $receiverId, $receiverId, $user['id']]);
    $conv = $convStmt->fetch();
    if(!$conv) {
        getDb()->prepare("INSERT INTO conversations (user1_id, user2_id, last_message_time) VALUES (?,?, NOW())")->execute([$user['id'], $receiverId]);
        $convId = getDb()->lastInsertId();
    } else $convId = $conv['id'];
    // Insert message
    $stmt = getDb()->prepare("INSERT INTO messages (conversation_id, sender_id, receiver_id, message) VALUES (?,?,?,?)");
    $stmt->execute([$convId, $user['id'], $receiverId, $message]);
    // Update conversation last message
    getDb()->prepare("UPDATE conversations SET last_message=?, last_message_time=NOW() WHERE id=?")->execute([$message, $convId]);
    sendNotification($receiverId, 'message', 'New message from '.$user['name'], $message, BASE_URL.'messaging.php?conv='.$convId);
    
    // Real-time push via Pusher
    $channel = "private-chat-{$convId}";
    sendRealtimeMessage($channel, 'new-message', [
        'sender_id' => $user['id'],
        'sender_name' => $user['name'],
        'message' => $message,
        'time' => date('H:i')
    ]);
    
    echo json_encode(['success'=>true]);
}