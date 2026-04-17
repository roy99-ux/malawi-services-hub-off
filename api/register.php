<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Adjust the path to includes folder (go up one level from api/)
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $role = $_POST['role'] ?? 'customer';

    // Validation
    if (empty($name)) $response['message'] = 'Name is required';
    elseif (empty($email)) $response['message'] = 'Email is required';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $response['message'] = 'Invalid email';
    elseif (strlen($password) < 8) $response['message'] = 'Password must be at least 8 characters';
    elseif ($password !== $confirm) $response['message'] = 'Passwords do not match';
    elseif (empty($phone)) $response['message'] = 'Phone is required';
    elseif (empty($location)) $response['message'] = 'Location is required';
    else {
        try {
            $db = getDb(); // Now this should work
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $response['message'] = 'Email already registered';
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $token = generateRandomToken();
                $stmt = $db->prepare("INSERT INTO users (name, email, password, phone, location, role, email_verification_token) VALUES (?, ?, ?, ?, ?, ?, ?)");
                if ($stmt->execute([$name, $email, $hashed, $phone, $location, $role, $token])) {
                    $userId = $db->lastInsertId();
                    if ($role === 'provider') {
                        $pStmt = $db->prepare("INSERT INTO portfolios (user_id, location) VALUES (?, ?)");
                        $pStmt->execute([$userId, $location]);
                    }
                    $response['success'] = true;
                    $response['message'] = 'Registration successful! Please login.';
                } else {
                    $response['message'] = 'Database insert failed';
                }
            }
        } catch (PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    }
}
echo json_encode($response);
?>