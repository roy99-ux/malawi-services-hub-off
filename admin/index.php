<?php require_once '../includes/auth.php'; requireRole('admin'); ?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><script src="https://cdn.jsdelivr.net/npm/chart.js"></script></head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 bg-dark min-vh-100 p-3">
            <a href="index.php" class="text-white d-block mb-3">Dashboard</a>
            <a href="users.php" class="text-white d-block mb-3">Users</a>
            <a href="analytics.php" class="text-white d-block mb-3">Analytics</a>
            <a href="content.php" class="text-white d-block mb-3">Content</a>
            <a href="settings.php" class="text-white d-block mb-3">Settings</a>
            <a href="backup.php" class="text-white d-block mb-3">Backup</a>
        </div>
        <div class="col-md-10 p-4">
            <h2>Admin Dashboard</h2>
            <div class="row">
                <?php
                $totalUsers = getDb()->query("SELECT COUNT(*) FROM users")->fetchColumn();
                $totalProviders = getDb()->query("SELECT COUNT(*) FROM users WHERE role='provider'")->fetchColumn();
                $totalBookings = getDb()->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
                $totalRevenue = getDb()->query("SELECT SUM(quote_amount) FROM bookings WHERE status='completed'")->fetchColumn();
                ?>
                <div class="col-md-3"><div class="card text-white bg-primary mb-3"><div class="card-body"><h5>Users</h5><h2><?= $totalUsers ?></h2></div></div></div>
                <div class="col-md-3"><div class="card text-white bg-success mb-3"><div class="card-body"><h5>Providers</h5><h2><?= $totalProviders ?></h2></div></div></div>
                <div class="col-md-3"><div class="card text-white bg-info mb-3"><div class="card-body"><h5>Bookings</h5><h2><?= $totalBookings ?></h2></div></div></div>
                <div class="col-md-3"><div class="card text-white bg-warning mb-3"><div class="card-body"><h5>Revenue (MWK)</h5><h2><?= number_format($totalRevenue) ?></h2></div></div></div>
            </div>
            <canvas id="revenueChart" height="100"></canvas>
            <script>
                new Chart(document.getElementById('revenueChart'), { type: 'line', data: { labels: ['Jan','Feb','Mar'], datasets: [{ label: 'Revenue', data: [1200,1500,2000] }] } });
            </script>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>