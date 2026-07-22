<?php
require_once '../includes/auth.php';
requireRole('admin');
$db = getDb();

// Clear logs
if (isset($_GET['clear'])) {
    $db->exec("DELETE FROM activity_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)");
    header('Location: activity.php');
    exit;
}

$logs = $db->query("SELECT l.*, u.name as user_name FROM activity_logs l LEFT JOIN users u ON l.user_id = u.id ORDER BY l.created_at DESC LIMIT 200")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Activity Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 bg-dark min-vh-100 p-3">
            <h5 class="text-white mb-3">Admin Panel</h5>
            <a href="index.php" class="text-white d-block mb-2"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a href="users.php" class="text-white d-block mb-2"><i class="fas fa-users"></i> Users</a>
            <a href="analytics.php" class="text-white d-block mb-2"><i class="fas fa-chart-bar"></i> Analytics</a>
            <a href="content.php" class="text-white d-block mb-2"><i class="fas fa-edit"></i> Content</a>
            <a href="settings.php" class="text-white d-block mb-2"><i class="fas fa-cog"></i> Settings</a>
            <a href="backup.php" class="text-white d-block mb-2"><i class="fas fa-database"></i> Backup</a>
            <a href="activity.php" class="text-white d-block mb-2 bg-primary p-2 rounded"><i class="fas fa-history"></i> Activity Logs</a>
        </div>
        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-history"></i> Activity Logs</h2>
                <a href="?clear=1" class="btn btn-secondary" onclick="return confirm('Delete logs older than 30 days?')"><i class="fas fa-trash"></i> Clean Old Logs</a>
            </div>
            
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="logsTable">
                        <thead>
                            <tr><th>Time</th><th>User</th><th>Action</th><th>Entity</th><th>Details</th><th>IP Address</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach($logs as $log): ?>
                            <tr>
                                <td><?= date('Y-m-d H:i:s', strtotime($log['created_at'])) ?></td>
                                <td><?= htmlspecialchars($log['user_name'] ?? 'System') ?> (<small><?= $log['user_id'] ?? 'N/A' ?></small>)</td>
                                <td><span class="badge bg-info"><?= htmlspecialchars($log['action']) ?></span></td>
                                <td><?= htmlspecialchars($log['entity_type'] ?? '-') ?> (ID: <?= $log['entity_id'] ?? '-'?>)</td>
                                <td><?= htmlspecialchars(substr($log['details'] ?? '', 0, 100)) ?>...</td>
                                <td><?= htmlspecialchars($log['ip_address'] ?? '-') ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($logs)): ?><tr><td colspan="6" class="text-center">No activity logs found</td></tr><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>$(document).ready(function(){$('#logsTable').DataTable({order:[[0,'desc']]});});</script>
<?php include '../includes/footer.php'; ?>
</body>
</html>