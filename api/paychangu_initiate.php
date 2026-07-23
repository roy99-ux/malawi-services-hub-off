<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireLogin();

header('Content-Type: application/json');

$user = getCurrentUser();
if ($user['role'] !== 'customer') {
    die(json_encode(['error' => 'Only customers can initiate payments.']));
}

$bookingId = $_POST['booking_id'] ?? 0;
if (!$bookingId) {
    die(json_encode(['error' => 'Booking ID required.']));
}

$db = getDb();

// Fetch booking with validation
$stmt = $db->prepare("SELECT b.*, u.name as provider_name, u.phone as provider_phone 
                       FROM bookings b 
                       JOIN users u ON b.provider_id = u.id 
                       WHERE b.id = ? AND b.customer_id = ? AND b.status = 'confirmed'");
if (!$stmt) {
    die(json_encode(['error' => 'Database prepare failed: ' . print_r($db->errorInfo(), true)]));
}
$stmt->execute([$bookingId, $user['id']]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die(json_encode(['error' => 'Booking not found or not confirmed.']));
}

$amount = $booking['negotiated_amount'] ?? $booking['quote_amount'];
if (!$amount || $amount <= 0) {
    die(json_encode(['error' => 'Invalid amount.']));
}

// Check if already paid
if ($booking['payment_status'] === 'paid') {
    die(json_encode(['error' => 'This booking has already been paid.']));
}

// Build PayChangu payload
$payload = [
    'store_id' => PAYCHANGU_STORE_ID,
    'store_key' => PAYCHANGU_STORE_KEY,
    'amount' => $amount,
    'currency' => 'MWK',
    'reference' => 'BOOK-' . $bookingId . '-' . time(),
    'customer_name' => $user['name'],
    'customer_email' => $user['email'],
    'customer_phone' => $user['phone'],
    'callback_url' => BASE_URL . 'api/paychangu_callback.php',
    'return_url' => BASE_URL . 'customer/my_bookings.php?id=' . $bookingId,
    'description' => "Payment for booking #{$bookingId} - " . $booking['provider_name']
];

// Initiate payment
$ch = curl_init(PAYCHANGU_API_URL . "/payment/initiate");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if (!$response) {
    die(json_encode(['error' => 'Payment gateway did not respond.']));
}

$result = json_decode($response, true);
if (!isset($result['status']) || $result['status'] !== 'success') {
    die(json_encode(['error' => 'Payment initiation failed: ' . ($result['message'] ?? 'Unknown error')]));
}

// Save transaction reference
$stmt = $db->prepare("UPDATE bookings SET transaction_id = ? WHERE id = ?");
$stmt->execute([$result['data']['reference'], $bookingId]);

// Return redirect URL
echo json_encode([
    'success' => true,
    'redirect_url' => $result['data']['checkout_url']
]);