<?php
require_once '../includes/auth.php';
requireRole('admin');
$db = getDb();

// Handle user deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
    $stmt->execute([$_GET['delete']]);
    header('Location: users.php?msg=deleted');
    exit;
}

// Handle user add/edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_user'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $phone = $_POST['phone'];
        $location = $_POST['location'];
        $role = $_POST['role'];
        $stmt = $db->prepare("INSERT INTO users (name, email, password, phone, location, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $phone, $location, $role]);
        header('Location: users.php?msg=added');
        exit;
    }
    
    if (isset($_POST['edit_user'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $location = $_POST['location'];
        $role = $_POST['role'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $stmt = $db->prepare("UPDATE users SET name=?, email=?, phone=?, location=?, role=?, is_active=? WHERE id=?");
        $stmt->execute([$name, $email, $phone, $location, $role, $is_active, $id]);
        header('Location: users.php?msg=updated');
        exit;
    }
}

// Fetch all users
$users = $db->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 bg-dark min-vh-100 p-3">
            <h5 class="text-white mb-3">Admin Panel</h5>
            <a href="index.php" class="text-white d-block mb-2"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a href="users.php" class="text-white d-block mb-2 bg-primary p-2 rounded"><i class="fas fa-users"></i> Users</a>
            <a href="analytics.php" class="text-white d-block mb-2"><i class="fas fa-chart-bar"></i> Analytics</a>
            <a href="content.php" class="text-white d-block mb-2"><i class="fas fa-edit"></i> Content</a>
            <a href="settings.php" class="text-white d-block mb-2"><i class="fas fa-cog"></i> Settings</a>
            <a href="backup.php" class="text-white d-block mb-2"><i class="fas fa-database"></i> Backup</a>
            <a href="activity.php" class="text-white d-block mb-2"><i class="fas fa-history"></i> Activity Logs</a>
        </div>
        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-users"></i> User Management</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus"></i> Add New User
                </button>
            </div>
            
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php 
                        if ($_GET['msg'] == 'added') echo "User added successfully!";
                        if ($_GET['msg'] == 'updated') echo "User updated successfully!";
                        if ($_GET['msg'] == 'deleted') echo "User deleted successfully!";
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <div class="card shadow">
                <div class="card-body">
                    <table id="usersTable" class="table table-bordered table-striped">
                        <thead>
                            <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Location</th><th>Role</th><th>Status</th><th>Joined</th><th>Actions</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= htmlspecialchars($user['name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['phone']) ?></td>
                                <td><?= htmlspecialchars($user['location']) ?></td>
                                <td><span class="badge bg-<?= $user['role'] == 'admin' ? 'danger' : ($user['role'] == 'provider' ? 'success' : 'info') ?>"><?= $user['role'] ?></span></td>
                                <td><span class="badge bg-<?= $user['is_active'] ? 'success' : 'secondary' ?>"><?= $user['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                                <td><?= date('Y-m-d', strtotime($user['created_at'])) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-user" data-id="<?= $user['id'] ?>" data-name="<?= htmlspecialchars($user['name']) ?>" data-email="<?= $user['email'] ?>" data-phone="<?= $user['phone'] ?>" data-location="<?= $user['location'] ?>" data-role="<?= $user['role'] ?>" data-active="<?= $user['is_active'] ?>"><i class="fas fa-edit"></i></button>
                                    <?php if ($user['role'] != 'admin'): ?>
                                    <a href="?delete=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')"><i class="fas fa-trash"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white"><h5>Add New User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form method="POST">
                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-2" placeholder="Full Name" required>
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                    <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                    <input type="text" name="phone" class="form-control mb-2" placeholder="Phone">
                    <select name="location" class="form-select mb-2" required>
                        <option value="">Select Location</option>
                        <option>Lilongwe</option><option>Blantyre</option><option>Mzuzu</option><option>Zomba</option>
                    </select>
                    <select name="role" class="form-select mb-2">
                        <option value="customer">Customer</option><option value="provider">Provider</option><option value="admin">Admin</option>
                    </select>
                </div>
                <div class="modal-footer"><button type="submit" name="add_user" class="btn btn-primary">Add User</button></div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning"><h5>Edit User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <input type="text" name="name" id="edit-name" class="form-control mb-2" required>
                    <input type="email" name="email" id="edit-email" class="form-control mb-2" required>
                    <input type="text" name="phone" id="edit-phone" class="form-control mb-2">
                    <select name="location" id="edit-location" class="form-select mb-2">
                        <option>Lilongwe</option><option>Blantyre</option><option>Mzuzu</option><option>Zomba</option>
                    </select>
                    <select name="role" id="edit-role" class="form-select mb-2">
                        <option value="customer">Customer</option><option value="provider">Provider</option><option value="admin">Admin</option>
                    </select>
                    <div class="form-check"><input type="checkbox" name="is_active" id="edit-active" class="form-check-input"> <label class="form-check-label">Active</label></div>
                </div>
                <div class="modal-footer"><button type="submit" name="edit_user" class="btn btn-warning">Save Changes</button></div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {$('#usersTable').DataTable();});
$('.edit-user').click(function() {
    $('#edit-id').val($(this).data('id'));
    $('#edit-name').val($(this).data('name'));
    $('#edit-email').val($(this).data('email'));
    $('#edit-phone').val($(this).data('phone'));
    $('#edit-location').val($(this).data('location'));
    $('#edit-role').val($(this).data('role'));
    $('#edit-active').prop('checked', $(this).data('active') == 1);
    $('#editUserModal').modal('show');
});
</script>
<?php include '../includes/footer.php'; ?>
</body>
</html>