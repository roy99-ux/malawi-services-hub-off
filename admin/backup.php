<?php
require_once '../includes/auth.php';
requireRole('admin');
$db = getDb();

$backupDir = __DIR__ . '/../backups/';
if (!is_dir($backupDir)) mkdir($backupDir, 0777, true);

// Create backup
if (isset($_POST['create_backup'])) {
    $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $filepath = $backupDir . $filename;
    
    // Get all tables
    $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    $sql = "-- Malawi Service Marketplace Backup\n-- Date: " . date('Y-m-d H:i:s') . "\n\n";
    
    foreach ($tables as $table) {
        $create = $db->query("SHOW CREATE TABLE $table")->fetch();
        $sql .= "DROP TABLE IF EXISTS `$table`;\n";
        $sql .= $create['Create Table'] . ";\n\n";
        
        $rows = $db->query("SELECT * FROM $table");
        while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
            $columns = array_keys($row);
            $values = array_map(function($v) use ($db) { return $db->quote($v); }, array_values($row));
            $sql .= "INSERT INTO `$table` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ");\n";
        }
        $sql .= "\n";
    }
    
    file_put_contents($filepath, $sql);
    header('Location: backup.php?msg=backup_created');
    exit;
}

// Restore backup
if (isset($_POST['restore_backup']) && isset($_FILES['backup_file']) && $_FILES['backup_file']['error'] == 0) {
    $sql = file_get_contents($_FILES['backup_file']['tmp_name']);
    try {
        $db->exec("SET FOREIGN_KEY_CHECKS = 0");
        $db->exec($sql);
        $db->exec("SET FOREIGN_KEY_CHECKS = 1");
        header('Location: backup.php?msg=restored');
    } catch (PDOException $e) {
        $error = "Restore failed: " . $e->getMessage();
    }
    exit;
}

// Delete backup
if (isset($_GET['delete'])) {
    unlink($backupDir . $_GET['delete']);
    header('Location: backup.php');
    exit;
}

// List backups
$backups = glob($backupDir . '*.sql');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Backup</title>
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
            <a href="backup.php" class="text-white d-block mb-2 bg-primary p-2 rounded"><i class="fas fa-database"></i> Backup</a>
            <a href="activity.php" class="text-white d-block mb-2"><i class="fas fa-history"></i> Activity Logs</a>
        </div>
        <div class="col-md-10 p-4">
            <h2><i class="fas fa-database"></i> Database Backup & Restore</h2>
            
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success"><?= $_GET['msg'] == 'backup_created' ? 'Backup created successfully!' : 'Database restored successfully!' ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header bg-success text-white">Create Backup</div>
                        <div class="card-body">
                            <form method="POST">
                                <p>Create a full database backup (SQL file).</p>
                                <button type="submit" name="create_backup" class="btn btn-success"><i class="fas fa-download"></i> Create Backup Now</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header bg-warning">Restore Backup</div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <p>Upload a SQL backup file to restore.</p>
                                <input type="file" name="backup_file" class="form-control mb-2" accept=".sql" required>
                                <button type="submit" name="restore_backup" class="btn btn-warning" onclick="return confirm('This will overwrite current data. Continue?')"><i class="fas fa-upload"></i> Restore</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow">
                <div class="card-header bg-primary text-white">Available Backups</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead><tr><th>Filename</th><th>Size</th><th>Date</th><th>Actions</th></tr></thead>
                        <tbody>
                            <?php foreach($backups as $backup): $name = basename($backup); ?>
                            <tr>
                                <td><?= $name ?></td>
                                <td><?= round(filesize($backup) / 1024, 2) ?> KB</td>
                                <td><?= date('Y-m-d H:i:s', filemtime($backup)) ?></td>
                                <td>
                                    <a href="../backups/<?= $name ?>" class="btn btn-sm btn-info" download><i class="fas fa-download"></i></a>
                                    <a href="?delete=<?= urlencode($name) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this backup?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($backups)): ?><tr><td colspan="4" class="text-center">No backups found</td></tr><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>