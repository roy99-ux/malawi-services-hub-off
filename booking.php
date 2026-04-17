<?php
require_once 'includes/auth.php';
requireLogin();
$providerId = $_GET['provider'];
$customer = getCurrentUser();
if($_POST['action']=='request_quote') {
    $quote = $_POST['quote_amount'];
    $stmt = getDb()->prepare("INSERT INTO bookings (customer_id, provider_id, service_category_id, quote_amount, status) VALUES (?,?,?,?,'pending')");
    $stmt->execute([$customer['id'], $providerId, $_POST['category_id'], $quote]);
    $bookingId = getDb()->lastInsertId();
    sendNotification($providerId, 'booking', 'New quote request', "You have a new quote request from {$customer['name']}", BASE_URL."provider/bookings.php?id=$bookingId");
    header('Location: customer/my_bookings.php');
}
?>
<form method="POST">
    <input name="quote_amount" placeholder="Your budget (MWK)" required>
    <select name="category_id">...</select>
    <button name="action" value="request_quote">Send Quote Request</button>
</form>