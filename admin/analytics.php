<?php
require_once '../includes/auth.php';
requireRole('admin');
$db = getDb();

// Get date range for filtering
$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date = $_GET['end_date'] ?? date('Y-m-d');

// Fetch analytics data
$total_users = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_providers = $db->query("SELECT COUNT(*) FROM users WHERE role='provider'")->fetchColumn();
$total_customers = $db->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn();
$total_bookings = $db->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$completed_bookings = $db->query("SELECT COUNT(*) FROM bookings WHERE status='completed'")->fetchColumn();
$total_revenue = $db->query("SELECT SUM(quote_amount) FROM bookings WHERE status='completed'")->fetchColumn();
$pending_bookings = $db->query("SELECT COUNT(*) FROM bookings WHERE status IN ('pending','quoted','negotiating')")->fetchColumn();

// Monthly revenue data
$monthly = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, SUM(quote_amount) as revenue FROM bookings WHERE status='completed' GROUP BY month ORDER BY month DESC LIMIT 6")->fetchAll();
$months = array_reverse(array_column($monthly, 'month'));
$revenues = array_reverse(array_column($monthly, 'revenue'));

// Export to Excel
if (isset($_GET['export_excel'])) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="analytics_'.date('Y-m-d').'.xls"');
    echo "Month\tRevenue\tBookings\n";
    foreach ($monthly as $m) echo $m['month']."\t".($m['revenue']??0)."\t\n";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Analytics - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 bg-dark min-vh-100 p-3">
            <h5 class="text-white mb-3">Admin Panel</h5>
            <a href="index.php" class="text-white d-block mb-2"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a href="users.php" class="text-white d-block mb-2"><i class="fas fa-users"></i> Users</a>
            <a href="analytics.php" class="text-white d-block mb-2 bg-primary p-2 rounded"><i class="fas fa-chart-bar"></i> Analytics</a>
            <a href="content.php" class="text-white d-block mb-2"><i class="fas fa-edit"></i> Content</a>
            <a href="settings.php" class="text-white d-block mb-2"><i class="fas fa-cog"></i> Settings</a>
            <a href="backup.php" class="text-white d-block mb-2"><i class="fas fa-database"></i> Backup</a>
            <a href="activity.php" class="text-white d-block mb-2"><i class="fas fa-history"></i> Activity Logs</a>
        </div>
        <div class="col-md-10 p-4">
            <h2><i class="fas fa-chart-bar"></i> Analytics & Reports</h2>
            
            <div class="row mb-4">
                <div class="col-md-3"><div class="card text-white bg-primary"><div class="card-body"><h6>Total Users</h6><h3><?= number_format($total_users) ?></h3></div></div></div>
                <div class="col-md-3"><div class="card text-white bg-success"><div class="card-body"><h6>Providers</h6><h3><?= number_format($total_providers) ?></h3></div></div></div>
                <div class="col-md-3"><div class="card text-white bg-info"><div class="card-body"><h6>Total Bookings</h6><h3><?= number_format($total_bookings) ?></h3></div></div></div>
                <div class="col-md-3"><div class="card text-white bg-warning"><div class="card-body"><h6>Revenue (MWK)</h6><h3><?= number_format($total_revenue) ?></h3></div></div></div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header">Revenue Trend (Last 6 Months)</div>
                        <div class="card-body"><canvas id="revenueChart"></canvas></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header">User Distribution</div>
                        <div class="card-body"><canvas id="userChart"></canvas></div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between">
                    <span>Monthly Revenue Report</span>
                    <a href="?export_excel=1" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export to Excel</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead><tr><th>Month</th><th>Revenue (MWK)</th></tr></thead>
                        <tbody>
                            <?php foreach($monthly as $m): ?>
                            <tr><td><?= $m['month'] ?></td><td><?= number_format($m['revenue'] ?? 0) ?></td></tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
new Chart(document.getElementById('revenueChart'), { type: 'line', data: { labels: <?= json_encode($months) ?>, datasets: [{ label: 'Revenue (MWK)', data: <?= json_encode($revenues) ?>, borderColor: 'blue', fill: false }] } });
new Chart(document.getElementById('userChart'), { type: 'pie', data: { labels: ['Customers', 'Providers'], datasets: [{ data: [<?= $total_customers ?>, <?= $total_providers ?>], backgroundColor: ['green', 'orange'] }] } });
</script>
<?php include '../includes/footer.php'; ?>
</body>
</html>