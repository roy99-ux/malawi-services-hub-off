<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']) ? true : false;

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit;
}

// Get user with password
$stmt = getDb()->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    // Log failed attempt
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    exit;
}

// Check if account is active
if (!$user['is_active']) {
    echo json_encode(['success' => false, 'message' => 'Your account has been deactivated. Contact support.']);
    exit;
}

// Update last login
$stmt = getDb()->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
$stmt->execute([$user['id']]);

// Set session
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_role'] = $user['role'];

// Remember me (30 days)
if ($remember) {
    $token = generateRandomToken();
    setcookie('remember_token', $token, time() + (86400 * 30), '/');
    // Store token in database (implement if needed)
}

// Log activity
logActivity($user['id'], 'login', 'user', $user['id'], 'User logged in', $_SERVER['REMOTE_ADDR']);

// Determine redirect based on role
$redirect = BASE_URL . 'index.php';
if ($user['role'] === 'admin') {
    $redirect = BASE_URL . 'admin/';
} elseif ($user['role'] === 'provider') {
    $redirect = BASE_URL . 'provider/dashboard.php';
} elseif ($user['role'] === 'customer') {
    $redirect = BASE_URL . 'customer/dashboard.php';
}

echo json_encode([
    'success' => true,
    'message' => 'Login successful!',
    'redirect' => $redirect,
    'user' => [
        'name' => $user['name'],
        'role' => $user['role'],
        'is_profile_complete' => $user['is_profile_complete']
    ]
]);
?>