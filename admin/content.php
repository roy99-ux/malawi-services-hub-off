<?php
require_once '../includes/auth.php';
requireRole('admin');
$db = getDb();

// Handle category add/edit/delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_category'])) {
        $stmt = $db->prepare("INSERT INTO service_categories (name, icon) VALUES (?, ?)");
        $stmt->execute([$_POST['name'], $_POST['icon']]);
    }
    if (isset($_POST['edit_category'])) {
        $stmt = $db->prepare("UPDATE service_categories SET name=?, icon=?, is_active=? WHERE id=?");
        $stmt->execute([$_POST['name'], $_POST['icon'], $_POST['is_active'], $_POST['id']]);
    }
    if (isset($_POST['delete_category'])) {
        $stmt = $db->prepare("DELETE FROM service_categories WHERE id=?");
        $stmt->execute([$_POST['id']]);
    }
    header('Location: content.php');
    exit;
}

$categories = $db->query("SELECT * FROM service_categories ORDER BY id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Content Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 bg-dark min-vh-100 p-3">
            <h5 class="text-white mb-3">Admin Panel</h5>
            <a href="index.php" class="text-white d-block mb-2"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a href="users.php" class="text-white d-block mb-2"><i class="fas fa-users"></i> Users</a>
            <a href="analytics.php" class="text-white d-block mb-2"><i class="fas fa-chart-bar"></i> Analytics</a>
            <a href="content.php" class="text-white d-block mb-2 bg-primary p-2 rounded"><i class="fas fa-edit"></i> Content</a>
            <a href="settings.php" class="text-white d-block mb-2"><i class="fas fa-cog"></i> Settings</a>
            <a href="backup.php" class="text-white d-block mb-2"><i class="fas fa-database"></i> Backup</a>
            <a href="activity.php" class="text-white d-block mb-2"><i class="fas fa-history"></i> Activity Logs</a>
        </div>
        <div class="col-md-10 p-4">
            <h2><i class="fas fa-edit"></i> Content Management</h2>
            
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">Service Categories</div>
                <div class="card-body">
                    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i class="fas fa-plus"></i> Add Category</button>
                    <table class="table table-bordered">
                        <thead><tr><th>ID</th><th>Name</th><th>Icon</th><th>Status</th><th>Actions</th></tr></thead>
                        <tbody>
                            <?php foreach($categories as $cat): ?>
                            <tr>
                                <td><?= $cat['id'] ?></td>
                                <td><?= htmlspecialchars($cat['name']) ?></td>
                                <td><i class="fas fa-<?= $cat['icon'] ?>"></i> <?= $cat['icon'] ?></td>
                                <td><span class="badge bg-<?= $cat['is_active'] ? 'success' : 'secondary' ?>"><?= $cat['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-cat" data-id="<?= $cat['id'] ?>" data-name="<?= $cat['name'] ?>" data-icon="<?= $cat['icon'] ?>" data-active="<?= $cat['is_active'] ?>"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger delete-cat" data-id="<?= $cat['id'] ?>" data-name="<?= $cat['name'] ?>"><i class="fas fa-trash"></i></button>
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

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header bg-success text-white"><h5>Add Category</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form method="POST"><div class="modal-body">
        <input type="text" name="name" class="form-control mb-2" placeholder="Category Name" required>
        <input type="text" name="icon" class="form-control mb-2" placeholder="Font Awesome Icon (e.g., wrench, hammer)" required>
    </div><div class="modal-footer"><button type="submit" name="add_category" class="btn btn-success">Add</button></div></form>
</div></div></div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header bg-warning"><h5>Edit Category</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form method="POST"><div class="modal-body">
        <input type="hidden" name="id" id="edit-id">
        <input type="text" name="name" id="edit-name" class="form-control mb-2" required>
        <input type="text" name="icon" id="edit-icon" class="form-control mb-2" required>
        <select name="is_active" id="edit-active" class="form-select"><option value="1">Active</option><option value="0">Inactive</option></select>
    </div><div class="modal-footer"><button type="submit" name="edit_category" class="btn btn-warning">Save</button></div></form>
</div></div></div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCategoryModal"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header bg-danger text-white"><h5>Delete Category</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form method="POST"><div class="modal-body"><p>Delete <strong id="delete-name"></strong>?</p><input type="hidden" name="id" id="delete-id"></div><div class="modal-footer"><button type="submit" name="delete_category" class="btn btn-danger">Delete</button></div></form>
</div></div></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('.edit-cat').click(function(){ $('#edit-id').val($(this).data('id')); $('#edit-name').val($(this).data('name')); $('#edit-icon').val($(this).data('icon')); $('#edit-active').val($(this).data('active')); $('#editCategoryModal').modal('show'); });
$('.delete-cat').click(function(){ $('#delete-id').val($(this).data('id')); $('#delete-name').text($(this).data('name')); $('#deleteCategoryModal').modal('show'); });
</script>
<?php include '../includes/footer.php'; ?>
</body>
</html>