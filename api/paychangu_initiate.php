<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireLogin();

header('Content-Type: application/json');

$user = getCurrentUser();
if ($user['role'] !== 'customer') {
    http_response_code(403);
    echo json_encode(['error' => 'Only customers can initiate payments.']);
    exit;
}

$bookingId = $_POST['booking_id'] ?? 0;
if (!$bookingId) {
    http_response_code(400);
    echo json_encode(['error' => 'Booking ID required.']);
    exit;
}

$db = getDb();

// Fetch booking
$stmt = $db->prepare("SELECT b.*, u.name as provider_name, u.phone as provider_phone 
                       FROM bookings b 
                       JOIN users u ON b.provider_id = u.id 
                       WHERE b.id = ? AND b.customer_id = ? AND b.status = 'confirmed'");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Database prepare failed.']);
    exit;
}
$stmt->execute([$bookingId, $user['id']]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    http_response_code(404);
    echo json_encode(['error' => 'Booking not found or not confirmed.']);
    exit;
}

$amount = $booking['negotiated_amount'] ?? $booking['quote_amount'];
if (!$amount || $amount <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid amount.']);
    exit;
}

// Check for existing payment
if ($booking['payment_status'] === 'paid') {
    http_response_code(400);
    echo json_encode(['error' => 'This booking has already been paid.']);
    exit;
}

// PayChangu credentials
define('PAYCHANGU_STORE_ID', 'your_store_id_here');
define('PAYCHANGU_STORE_KEY', 'your_store_key_here');
define('PAYCHANGU_API_URL', 'https://api.paychangu.com/v1'); // use sandbox if testing

$payload = [
    'store_id' => PAYCHANGU_STORE_ID,
    'store_key' => PAYCHANGU_STORE_KEY,
    'amount' => (float) $amount,
    'currency' => 'MWK',
    'reference' => 'BOOK-' . $bookingId . '-' . time(),
    'customer_name' => $user['name'],
    'customer_email' => $user['email'],
    'customer_phone' => $user['phone'],
    'callback_url' => BASE_URL . 'api/paychangu_callback.php',
    'return_url' => BASE_URL . 'customer/my_bookings.php?id=' . $bookingId,
    'description' => "Payment for booking #{$bookingId} - " . $booking['provider_name']
];

// Log payload for debugging
error_log("PayChangu payload: " . json_encode($payload));

$ch = curl_init(PAYCHANGU_API_URL . "/payment/initiate");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // disable if localhost/self-signed

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    error_log("CURL Error: " . $curlError);
    http_response_code(500);
    echo json_encode(['error' => 'CURL error: ' . $curlError]);
    exit;
}

if (!$response) {
    http_response_code(500);
    echo json_encode(['error' => 'Payment gateway did not respond.']);
    exit;
}

error_log("PayChangu response: " . $response);
$result = json_decode($response, true);

if (!isset($result['status']) || $result['status'] !== 'success') {
    $message = $result['message'] ?? 'Unknown error';
    $fullMessage = "Payment initiation failed: " . $message;
    // If there's a data field with more details, show it
    if (isset($result['data']) && is_array($result['data'])) {
        $fullMessage .= " - " . json_encode($result['data']);
    }
    http_response_code(400);
    echo json_encode(['error' => $fullMessage]);
    exit;
}

// Save reference
$stmt = $db->prepare("UPDATE bookings SET transaction_id = ? WHERE id = ?");
$stmt->execute([$result['data']['reference'], $bookingId]);

echo json_encode([
    'success' => true,
    'redirect_url' => $result['data']['checkout_url']
]);