<?php
require_once '../includes/auth.php';
requireRole('provider');
$user = getCurrentUser();

// Check if profile is complete
if (!$user['is_profile_complete']) {
    header('Location: portfolio.php?msg=complete');
    exit;
}

// Fetch stats
$stmt = getDb()->prepare("SELECT COUNT(*) as total, SUM(CASE WHEN status='completed' THEN 1 ELSE 0 END) as completed 
                          FROM bookings WHERE provider_id = ?");
$stmt->execute([$user['id']]);
$stats = $stmt->fetch();

$pendingBookings = getDb()->prepare("SELECT * FROM bookings WHERE provider_id = ? AND status IN ('pending','quoted','negotiating') ORDER BY created_at DESC LIMIT 10");
$pendingBookings->execute([$user['id']]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Provider Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="dashboard.php" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="portfolio.php" class="list-group-item list-group-item-action">My Portfolio</a>
                <a href="bookings.php" class="list-group-item list-group-item-action">Bookings</a>
                <a href="../messaging.php" class="list-group-item list-group-item-action">Messages</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5>Provider Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4"><h3><?= $stats['total'] ?></h3><p>Total Bookings</p></div>
                        <div class="col-md-4"><h3><?= $stats['completed'] ?></h3><p>Completed</p></div>
                        <div class="col-md-4"><h3><?= $pendingBookings->rowCount() ?></h3><p>Pending Requests</p></div>
                    </div>
                    <h6>Recent Booking Requests</h6>
                    <table class="table table-sm">
                        <thead><tr><th>Customer</th><th>Quote</th><th>Status</th><th>Action</th></tr></thead>
                        <tbody>
                            <?php while($b = $pendingBookings->fetch()): 
                                $cust = getDb()->prepare("SELECT name FROM users WHERE id=?")->execute([$b['customer_id']])->fetch();
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($cust['name']) ?></td>
                                <td>MWK <?= number_format($b['quote_amount']) ?></td>
                                <td><?= ucfirst($b['status']) ?></td>
                                <td><a href="bookings.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-info">Respond</a></td>
                            </tr>
                            <?php endwhile; ?>
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