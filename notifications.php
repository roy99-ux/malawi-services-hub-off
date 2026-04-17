<?php
require_once 'includes/auth.php';
requireLogin();
$user = getCurrentUser();

// Mark all as read if requested
if (isset($_GET['mark_read'])) {
    getDb()->prepare("UPDATE notifications SET is_read=1 WHERE user_id=?")->execute([$user['id']]);
    header('Location: notifications.php');
    exit;
}

// Fetch notifications
$stmt = getDb()->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 50");
$stmt->execute([$user['id']]);
$notifications = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fas fa-bell"></i> Notifications</h2>
        <a href="?mark_read=1" class="btn btn-sm btn-secondary">Mark all as read</a>
    </div>

    <div class="list-group">
        <?php if(empty($notifications)): ?>
            <div class="list-group-item text-center text-muted">No notifications yet.</div>
        <?php else: ?>
            <?php foreach($notifications as $notif): ?>
                <div class="list-group-item <?= $notif['is_read'] ? '' : 'list-group-item-warning' ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1"><?= htmlspecialchars($notif['title']) ?></h6>
                            <p class="mb-1"><?= htmlspecialchars($notif['message']) ?></p>
                            <small class="text-muted"><?= date('F j, Y g:i a', strtotime($notif['created_at'])) ?></small>
                        </div>
                        <?php if($notif['link']): ?>
                            <a href="<?= $notif['link'] ?>" class="btn btn-sm btn-primary">View</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>