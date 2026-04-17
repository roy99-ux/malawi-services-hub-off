<?php
require_once '../includes/auth.php';
requireLogin();
$user = getCurrentUser();

$bookingId = $_GET['id'] ?? 0;
if ($bookingId) {
    // Show single booking details + payment button
    $stmt = getDb()->prepare("SELECT b.*, u.name as provider_name, u.phone as provider_phone, sc.name as category 
                              FROM bookings b 
                              JOIN users u ON b.provider_id = u.id 
                              JOIN service_categories sc ON b.service_category_id = sc.id 
                              WHERE b.id = ? AND b.customer_id = ?");
    $stmt->execute([$bookingId, $user['id']]);
    $booking = $stmt->fetch();
    if (!$booking) die("Booking not found");
    ?>
    <!DOCTYPE html>
    <html>
    <head><title>Booking Details</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
    <body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-4">
        <h3>Booking #<?= $booking['id'] ?></h3>
        <div class="card">
            <div class="card-body">
                <p><strong>Provider:</strong> <?= htmlspecialchars($booking['provider_name']) ?></p>
                <p><strong>Service:</strong> <?= $booking['category'] ?></p>
                <p><strong>Quote Amount:</strong> MWK <?= number_format($booking['quote_amount']) ?></p>
                <p><strong>Negotiated Amount:</strong> MWK <?= number_format($booking['negotiated_amount'] ?? $booking['quote_amount']) ?></p>
                <p><strong>Status:</strong> <?= ucfirst($booking['status']) ?></p>
                <p><strong>Payment Status:</strong> <?= ucfirst($booking['payment_status']) ?></p>
                <?php if ($booking['status'] == 'confirmed' && $booking['payment_status'] == 'pending'): ?>
                    <form action="../api/paychangu_initiate.php" method="POST">
                        <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                        <input type="hidden" name="amount" value="<?= $booking['negotiated_amount'] ?? $booking['quote_amount'] ?>">
                        <button type="submit" class="btn btn-success">Pay with Mobile Money (Airtel/TNM)</button>
                    </form>
                <?php elseif($booking['payment_status'] == 'paid'): ?>
                    <div class="alert alert-success">Payment completed. The provider will contact you.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
    </body>
    </html>
    <?php
    exit;
}

// List all bookings
$stmt = getDb()->prepare("SELECT b.*, u.name as provider_name, sc.name as category 
                          FROM bookings b 
                          JOIN users u ON b.provider_id = u.id 
                          JOIN service_categories sc ON b.service_category_id = sc.id 
                          WHERE b.customer_id = ? 
                          ORDER BY b.created_at DESC");
$stmt->execute([$user['id']]);
$bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>My Bookings</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2>My Bookings</h2>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Provider</th><th>Service</th><th>Amount</th><th>Status</th><th>Payment</th><th>Action</th></tr></thead>
        <tbody>
            <?php foreach($bookings as $b): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= htmlspecialchars($b['provider_name']) ?></td>
                <td><?= $b['category'] ?></td>
                <td>MWK <?= number_format($b['negotiated_amount'] ?? $b['quote_amount']) ?></td>
                <td><?= ucfirst($b['status']) ?></td>
                <td><?= ucfirst($b['payment_status']) ?></td>
                <td><a href="?id=<?= $b['id'] ?>" class="btn btn-sm btn-primary">View</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>