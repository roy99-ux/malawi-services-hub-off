<?php
require_once '../includes/auth.php';
requireRole('admin');
$db = getDb();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['settings'] as $key => $value) {
        $stmt = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
        $stmt->execute([$key, $value, $value]);
    }
    header('Location: settings.php?msg=saved');
    exit;
}

$settings = [];
$stmt = $db->query("SELECT * FROM settings");
while($row = $stmt->fetch()) { $settings[$row['setting_key']] = $row['setting_value']; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Settings</title>
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
            <a href="settings.php" class="text-white d-block mb-2 bg-primary p-2 rounded"><i class="fas fa-cog"></i> Settings</a>
            <a href="backup.php" class="text-white d-block mb-2"><i class="fas fa-database"></i> Backup</a>
            <a href="activity.php" class="text-white d-block mb-2"><i class="fas fa-history"></i> Activity Logs</a>
        </div>
        <div class="col-md-10 p-4">
            <h2><i class="fas fa-cog"></i> System Settings</h2>
            <?php if (isset($_GET['msg'])): ?><div class="alert alert-success">Settings saved successfully!</div><?php endif; ?>
            
            <form method="POST">
                <div class="card shadow mb-4"><div class="card-header bg-primary text-white">General Settings</div>
                <div class="card-body">
                    <div class="mb-3"><label>Site Name</label><input type="text" name="settings[site_name]" class="form-control" value="<?= $settings['site_name'] ?? 'Malawi Service Marketplace' ?>"></div>
                    <div class="mb-3"><label>Admin Email</label><input type="email" name="settings[admin_email]" class="form-control" value="<?= $settings['admin_email'] ?? 'admin@malawiservicehub.mw' ?>"></div>
                    <div class="mb-3"><label>Commission Fee (%)</label><input type="number" step="0.01" name="settings[commission_fee]" class="form-control" value="<?= $settings['commission_fee'] ?? '10' ?>"></div>
                </div></div>
                
                <div class="card shadow mb-4"><div class="card-header bg-info text-white">Email Configuration</div>
                <div class="card-body">
                    <div class="mb-3"><label>SMTP Host</label><input type="text" name="settings[smtp_host]" class="form-control" value="<?= $settings['smtp_host'] ?? '' ?>"></div>
                    <div class="mb-3"><label>SMTP Port</label><input type="text" name="settings[smtp_port]" class="form-control" value="<?= $settings['smtp_port'] ?? '587' ?>"></div>
                    <div class="mb-3"><label>SMTP User</label><input type="text" name="settings[smtp_user]" class="form-control" value="<?= $settings['smtp_user'] ?? '' ?>"></div>
                    <div class="mb-3"><label>SMTP Password</label><input type="password" name="settings[smtp_pass]" class="form-control" value="<?= $settings['smtp_pass'] ?? '' ?>"></div>
                </div></div>
                
                <div class="card shadow mb-4"><div class="card-header bg-warning">Payment Configuration (PayChangu)</div>
                <div class="card-body">
                    <div class="mb-3"><label>Store ID</label><input type="text" name="settings[paychangu_store_id]" class="form-control" value="<?= $settings['paychangu_store_id'] ?? '' ?>"></div>
                    <div class="mb-3"><label>Store Key</label><input type="password" name="settings[paychangu_store_key]" class="form-control" value="<?= $settings['paychangu_store_key'] ?? '' ?>"></div>
                    <div class="mb-3"><label>API URL</label><input type="text" name="settings[paychangu_api_url]" class="form-control" value="<?= $settings['paychangu_api_url'] ?? 'https://api.paychangu.com/v1' ?>"></div>
                </div></div>
                
                <button type="submit" class="btn btn-primary">Save All Settings</button>
            </form>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>