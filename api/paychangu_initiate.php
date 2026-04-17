<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireLogin();

$bookingId = $_POST['booking_id'];
$amount = (float)$_POST['amount'];
$user = getCurrentUser();

$booking = getDb()->prepare("SELECT * FROM bookings WHERE id=? AND customer_id=? AND status='confirmed'")->execute([$bookingId, $user['id']])->fetch();
if(!$booking) die("Invalid booking");

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
    'description' => "Payment for booking #{$bookingId}"
];

$ch = curl_init(PAYCHANGU_API_URL . "/payment/initiate");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$result = json_decode($response, true);
if($result['status'] == 'success') {
    getDb()->prepare("UPDATE bookings SET transaction_id = ? WHERE id = ?")->execute([$result['data']['reference'], $bookingId]);
    header("Location: " . $result['data']['checkout_url']);
} else {
    die("Payment initiation failed: " . $result['message']);
}