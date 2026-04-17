<?php
require_once '../includes/db.php';
$input = json_decode(file_get_contents('php://input'), true);
if($input['status'] == 'completed') {
    $reference = $input['reference'];
    preg_match('/BOOK-(\d+)-/', $reference, $matches);
    $bookingId = $matches[1];
    getDb()->prepare("UPDATE bookings SET payment_status='paid', status='in_progress', payment_method='mobile_money' WHERE id=?")->execute([$bookingId]);
    // Notify
    $booking = getDb()->prepare("SELECT * FROM bookings WHERE id=?")->execute([$bookingId])->fetch();
    sendNotification($booking['provider_id'], 'payment', 'Payment received', "Customer paid MWK {$input['amount']} for booking #$bookingId");
}
http_response_code(200);