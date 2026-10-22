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
$stmt = $db->prepare("SELECT b.*, u.name as provider_name FROM bookings b JOIN users u ON b.provider_id = u.id WHERE b.id = ? AND b.customer_id = ? AND b.status = 'confirmed'");
$stmt->execute([$bookingId, $user['id']]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$booking) {
    die(json_encode(['error' => 'Booking not found or not confirmed.']));
}

$amount = $booking['negotiated_amount'] ?? $booking['quote_amount'];
if (!$amount || $amount <= 0) {
    die(json_encode(['error' => 'Invalid amount.']));
}
if ($booking['payment_status'] === 'paid') {
    die(json_encode(['error' => 'Already paid.']));
}

$payload = [
    'store_id' => PAYCHANGU_STORE_ID,
    'store_key' => PAYCHANGU_STORE_KEY,
    'amount' => (float)$amount,
    'currency' => 'MWK',
    'reference' => 'BOOK-' . $bookingId . '-' . time(),
    'customer_name' => $user['name'],
    'customer_email' => $user['email'],
    'customer_phone' => $user['phone'],
    'callback_url' => BASE_URL . 'api/paychangu_callback.php',
    'return_url' => BASE_URL . 'customer/my_bookings.php?id=' . $bookingId,
    'description' => "Payment for booking #{$bookingId} - " . $booking['provider_name']
];

$url = PAYCHANGU_API_URL . "/payment/initiate";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_VERBOSE, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    die(json_encode(['error' => 'CURL error: ' . $curlError]));
}

// Log the full response for debugging
error_log("PayChangu response (HTTP $httpCode): " . $response);

if ($httpCode !== 200) {
    // Try to parse error message from response
    $decoded = json_decode($response, true);
    $msg = $decoded['message'] ?? $decoded['error'] ?? $response;
    die(json_encode(['error' => "HTTP $httpCode: $msg"]));
}

$result = json_decode($response, true);
if (!$result) {
    die(json_encode(['error' => 'Invalid JSON: ' . $response]));
}

if (!isset($result['status']) || $result['status'] !== 'success') {
    $msg = $result['message'] ?? $result['error'] ?? 'Unknown error';
    die(json_encode(['error' => "Payment failed: $msg"]));
}

$stmt = $db->prepare("UPDATE bookings SET transaction_id = ? WHERE id = ?");
$stmt->execute([$result['data']['reference'], $bookingId]);

echo json_encode([
    'success' => true,
    'redirect_url' => $result['data']['checkout_url']
]);