<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
header('Content-Type: application/json');

$email = $_POST['email'] ?? '';
if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit;
}

$stmt = getDb()->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();
if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Email not found']);
    exit;
}

$token = generateRandomToken();
$expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
$stmt = getDb()->prepare("UPDATE users SET reset_password_token = ?, reset_password_expire = ? WHERE id = ?");
$stmt->execute([$token, $expires, $user['id']]);

$resetLink = BASE_URL . "reset_password.php?token=$token";
// Send email (simplified - use PHPMailer in production)
mail($email, "Password Reset - Malawi Service Hub", "Click this link to reset your password: $resetLink", "From: malawiserviceshub@gmail.com");

echo json_encode(['success' => true, 'message' => 'Password reset link sent to your email.']);