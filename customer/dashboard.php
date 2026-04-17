<?php
require_once '../includes/auth.php';
requireLogin();
$user = getCurrentUser();
if ($user['role'] != 'customer') {
    header('Location: ../index.php');
    exit;
}

// Recent bookings
$stmt = getDb()->prepare("SELECT b.*, u.name as provider_name, sc.name as category 
                          FROM bookings b 
                          JOIN users u ON b.provider_id = u.id 
                          JOIN service_categories sc ON b.service_category_id = sc.id 
                          WHERE b.customer_id = ? 
                          ORDER BY b.created_at DESC LIMIT 5");
$stmt->execute([$user['id']]);
$recentBookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="dashboard.php" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="my_bookings.php" class="list-group-item list-group-item-action">My Bookings</a>
                <a href="../messaging.php" class="list-group-item list-group-item-action">Messages</a>
                <a href="../notifications.php" class="list-group-item list-group-item-action">Notifications</a>
                <a href="../profile.php" class="list-group-item list-group-item-action">Profile</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Welcome, <?= htmlspecialchars($user['name']) ?>!</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-4">
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <h3><?= count($recentBookings) ?></h3>
                                <p>Total Bookings</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <h3><?= count(array_filter($recentBookings, fn($b) => $b['status'] == 'completed')) ?></h3>
                                <p>Completed</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <a href="my_bookings.php?status=pending" class="text-decoration-none">
                                    <h3><?= count(array_filter($recentBookings, fn($b) => $b['status'] == 'pending')) ?></h3>
                                    <p>Pending</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <h6>Recent Bookings</h6>
                    <table class="table table-sm">
                        <thead><tr><th>Provider</th><th>Service</th><th>Status</th><th>Action</th></tr></thead>
                        <tbody>
                            <?php foreach($recentBookings as $b): ?>
                            <tr>
                                <td><?= htmlspecialchars($b['provider_name']) ?></td>
                                <td><?= $b['category'] ?></td>
                                <td><?= ucfirst($b['status']) ?></td>
                                <td><a href="my_bookings.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-info">View</a></td>
                            </tr>
                            <?php endforeach; ?>
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