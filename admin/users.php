<?php require_once '../includes/auth.php'; requireRole('admin');
$action = $_GET['action'] ?? 'list';
if ($action == 'delete' && isset($_GET['id'])) {
    getDb()->prepare("DELETE FROM users WHERE id=?")->execute([$_GET['id']]);
    header('Location: users.php');
    exit;
}
if ($_POST['action'] == 'add') {
    $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
    getDb()->prepare("INSERT INTO users (name, email, password, phone, location, role) VALUES (?,?,?,?,?,?)")
        ->execute([$_POST['name'], $_POST['email'], $hashed, $_POST['phone'], $_POST['location'], $_POST['role']]);
    header('Location: users.php');
    exit;
}
if ($_POST['action'] == 'edit') {
    getDb()->prepare("UPDATE users SET name=?, email=?, phone=?, location=?, role=?, is_active=? WHERE id=?")
        ->execute([$_POST['name'], $_POST['email'], $_POST['phone'], $_POST['location'], $_POST['role'], $_POST['is_active'], $_POST['id']]);
    header('Location: users.php');
    exit;
}
$users = getDb()->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
?>
<!-- HTML table with edit/delete buttons and add user form -->