<?php
require_once 'includes/auth.php';
requireLogin();
$user = getCurrentUser();
$conversations = [];

// Fetch all conversations for current user
$stmt = getDb()->prepare("SELECT c.*, 
                          CASE WHEN c.user1_id = ? THEN u2.name ELSE u1.name END as other_name,
                          CASE WHEN c.user1_id = ? THEN u2.id ELSE u1.id END as other_id
                          FROM conversations c
                          JOIN users u1 ON u1.id = c.user1_id
                          JOIN users u2 ON u2.id = c.user2_id
                          WHERE c.user1_id = ? OR c.user2_id = ?
                          ORDER BY c.last_message_time DESC");
$stmt->execute([$user['id'], $user['id'], $user['id'], $user['id']]);
$conversations = $stmt->fetchAll();

$selectedConv = isset($_GET['conv']) ? (int)$_GET['conv'] : ($conversations[0]['id'] ?? 0);
$otherUser = null;
if ($selectedConv) {
    $convStmt = getDb()->prepare("SELECT * FROM conversations WHERE id = ?");
    $convStmt->execute([$selectedConv]);
    $conv = $convStmt->fetch();
    $otherId = ($conv['user1_id'] == $user['id']) ? $conv['user2_id'] : $conv['user1_id'];
    $otherStmt = getDb()->prepare("SELECT id, name, profile_pic FROM users WHERE id = ?");
    $otherStmt->execute([$otherId]);
    $otherUser = $otherStmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages – Malawi Service Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .chat-container { height: 500px; overflow-y: auto; padding: 15px; background: #f8f9fa; border-radius: 10px; }
        .message { margin-bottom: 15px; display: flex; }
        .message.sent { justify-content: flex-end; }
        .message.received { justify-content: flex-start; }
        .message-bubble { max-width: 70%; padding: 10px 15px; border-radius: 20px; }
        .sent .message-bubble { background: #007bff; color: white; }
        .received .message-bubble { background: #e9ecef; color: black; }
        .message-time { font-size: 0.7rem; margin-top: 5px; opacity: 0.7; }
        .conversation-item { cursor: pointer; transition: background 0.2s; }
        .conversation-item:hover, .conversation-item.active { background: #e9ecef; }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <!-- Conversation list -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-comments"></i> Conversations</h5>
                </div>
                <div class="list-group list-group-flush" id="conversationList">
                    <?php foreach($conversations as $conv): ?>
                        <a href="?conv=<?= $conv['id'] ?>" class="list-group-item list-group-item-action conversation-item <?= ($selectedConv == $conv['id']) ? 'active' : '' ?>">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?= htmlspecialchars($conv['other_name']) ?></strong>
                                    <div class="small text-muted"><?= htmlspecialchars(substr($conv['last_message'] ?? '', 0, 40)) ?></div>
                                </div>
                                <small><?= date('H:i', strtotime($conv['last_message_time'])) ?></small>
                            </div>
                        </a>
                    <?php endforeach; ?>
                    <?php if(empty($conversations)): ?>
                        <div class="list-group-item text-muted">No conversations yet. Start by requesting a quote from a provider.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Chat area -->
        <div class="col-md-8">
            <?php if($otherUser): ?>
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white d-flex align-items-center">
                        <img src="<?= $otherUser['profile_pic'] ?: 'assets/default-avatar.png' ?>" class="rounded-circle me-2" width="35" height="35">
                        <strong><?= htmlspecialchars($otherUser['name']) ?></strong>
                    </div>
                    <div class="chat-container" id="chatMessages">
                        <div class="text-center text-muted">Loading messages...</div>
                    </div>
                    <div class="card-footer">
                        <div class="mb-2" id="suggestionButtons"></div>
                        <div class="input-group">
                            <input type="text" id="messageInput" class="form-control" placeholder="Type a message...">
                            <button class="btn btn-primary" onclick="sendMessage()">Send</button>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-body text-center text-muted">
                        <i class="fas fa-comment-dots fa-3x mb-3"></i>
                        <p>Select a conversation to start chatting</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
const currentUserId = <?= $user['id'] ?>;
const otherUserId = <?= $otherUser['id'] ?? 0 ?>;
const convId = <?= $selectedConv ?: 0 ?>;

// Pusher real-time setup
const pusher = new Pusher('<?= PUSHER_APP_KEY ?>', { cluster: '<?= PUSHER_CLUSTER ?>', authEndpoint: 'api/pusher_auth.php' });
let channel = null;

function loadMessages() {
    if(!convId) return;
    $.ajax({
        url: 'api/messages.php',
        type: 'GET',
        data: { action: 'fetch', with: otherUserId, conv: convId },
        dataType: 'json',
        success: function(messages) {
            let html = '';
            messages.forEach(msg => {
                const isSent = msg.sender_id == currentUserId;
                html += `<div class="message ${isSent ? 'sent' : 'received'}">
                            <div class="message-bubble">
                                ${escapeHtml(msg.message)}
                                <div class="message-time">${msg.created_at}</div>
                            </div>
                         </div>`;
            });
            $('#chatMessages').html(html);
            $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
        }
    });
}

function sendMessage() {
    let msg = $('#messageInput').val().trim();
    if(!msg) return;
    $.ajax({
        url: 'api/messages.php',
        type: 'POST',
        data: { action: 'send', receiver_id: otherUserId, message: msg },
        dataType: 'json',
        success: function(res) {
            if(res.success) {
                $('#messageInput').val('');
                loadMessages();
            } else alert(res.error);
        }
    });
}

function loadSuggestions() {
    $.ajax({
        url: 'api/messages.php',
        type: 'GET',
        data: { action: 'suggestions' },
        dataType: 'json',
        success: function(sugs) {
            let btns = '';
            sugs.forEach(s => {
                btns += `<button class="btn btn-sm btn-outline-secondary me-2 mb-2" onclick="$('#messageInput').val('${s.replace(/'/g, "\\'")}'); sendMessage();">${s}</button>`;
            });
            $('#suggestionButtons').html(btns);
        }
    });
}

function escapeHtml(str) {
    return str.replace(/[&<>]/g, function(m) {
        if(m === '&') return '&amp;';
        if(m === '<') return '&lt;';
        if(m === '>') return '&gt;';
        return m;
    }).replace(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g, function(c) {
        return c;
    });
}

$(document).ready(function() {
    if(convId && otherUserId) {
        loadMessages();
        loadSuggestions();
        // Subscribe to Pusher channel
        channel = pusher.subscribe(`private-chat-${convId}`);
        channel.bind('new-message', function(data) {
            if(data.sender_id != currentUserId) {
                loadMessages(); // or append message without reload
            }
        });
        // Refresh messages every 10 sec as fallback
        setInterval(loadMessages, 10000);
    }
});
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>