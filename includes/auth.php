<?php
require_once 'db.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    if (!isLoggedIn()) return null;
    $stmt = getDb()->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . 'index.php?msg=login_required');
        exit;
    }
}

function requireRole($role) {
    requireLogin();
    $user = getCurrentUser();
    if ($user['role'] !== $role && $user['role'] !== 'admin') {
        header('Location: ' . BASE_URL . 'index.php?msg=unauthorized');
        exit;
    }
}

function requireProviderProfileComplete() {
    $user = getCurrentUser();
    if ($user['role'] === 'provider' && !$user['is_profile_complete']) {
        header('Location: ' . BASE_URL . 'provider/portfolio.php?msg=complete_profile_first');
        exit;
    }
}
?>