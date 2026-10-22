<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
header('Content-Type: application/json');

$respond = static function (int $status, bool $success, string $message): void {
    http_response_code($status);
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
};

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    $respond(405, false, 'This endpoint only accepts POST requests.');
}

$email = trim($_POST['email'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $respond(400, false, 'Please enter a valid email address.');
}

$db = getDb();
$stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();
if (!$user) {
    $respond(404, false, 'Email not found.');
}

$token = generateRandomToken();
$expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
$stmt = $db->prepare("UPDATE users SET reset_password_token = ?, reset_password_expire = ? WHERE id = ?");
$stmt->execute([$token, $expires, $user['id']]);

$resetLink = BASE_URL . 'reset_password.php?token=' . rawurlencode($token);
$mailWarning = null;
set_error_handler(static function (int $severity, string $message) use (&$mailWarning): bool {
    if ($severity === E_WARNING) {
        $mailWarning = $message;
        return true;
    }
    return false;
});

try {
    $sent = mail(
        $email,
        'Password Reset - Malawi Service Hub',
        "Click this link to reset your password: $resetLink",
        'From: malawiserviceshub@gmail.com'
    );
} finally {
    restore_error_handler();
}

if (!$sent) {
    if ($mailWarning !== null) {
        error_log('Password reset email could not be sent: ' . $mailWarning);
    }
    $stmt = $db->prepare('UPDATE users SET reset_password_token = NULL, reset_password_expire = NULL WHERE id = ? AND reset_password_token = ?');
    $stmt->execute([$user['id'], $token]);
    $respond(503, false, 'Unable to send the reset email. Please check the server email settings and try again.');
}

$respond(200, true, 'Password reset link sent to your email.');