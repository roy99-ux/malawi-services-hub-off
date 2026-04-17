<?php
require_once 'includes/auth.php';
requireLogin();
$user = getCurrentUser();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $location = trim($_POST['location']);
    
    $db = getDb();
    $stmt = $db->prepare("UPDATE users SET name = ?, phone = ?, location = ? WHERE id = ?");
    $stmt->execute([$name, $phone, $location, $user['id']]);
    
    // Handle profile picture upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'assets/uploads/profiles/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
        $fileName = 'user_' . $user['id'] . '_' . time() . '.' . $ext;
        $targetPath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetPath)) {
            $stmt = $db->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
            $stmt->execute([$targetPath, $user['id']]);
            $user['profile_pic'] = $targetPath;
        }
    }
    
    // Refresh user data
    $user = getCurrentUser();
    $success = "Profile updated successfully!";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - Malawi Service Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="<?= $user['role'] === 'customer' ? 'customer/dashboard.php' : 'provider/dashboard.php' ?>" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="profile.php" class="list-group-item list-group-item-action active">My Profile</a>
                <a href="notifications.php" class="list-group-item list-group-item-action">Notifications</a>
                <a href="logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Profile</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <div class="text-center mb-3">
                            <img src="<?= $user['profile_pic'] ?: 'assets/default-avatar.png' ?>" class="rounded-circle" width="120" height="120" style="object-fit: cover;">
                            <div class="mt-2">
                                <input type="file" name="profile_pic" accept="image/*" class="form-control-sm">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                            <small class="text-muted">Email cannot be changed</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <select name="location" class="form-select" required>
                                <option value="">Select your Location</option>
                                <?php
                                $locations = ['Lilongwe','Blantyre','Mzuzu','Zomba','Balaka','Chikwawa','Chiradzulu','Chitipa','Dedza','Dowa','Karonga','Kasungu','Machinga','Mangochi','Mchinji',
                                'Mulanje','Mwanza','Mzimba','Neno','Nkhatabay','Nkhotakota','Nsanje','Ntcheu','Ntchisi','Phalombe','Rumphi','Salima','Thyolo'];
                                foreach ($locations as $loc) {
                                    $selected = ($user['location'] == $loc) ? 'selected' : '';
                                    echo "<option value='$loc' $selected>$loc</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                    
                    <hr>
                    <h6>Account Information</h6>
                    <p><strong>Role:</strong> <?= ucfirst($user['role']) ?><br>
                    <strong>Member since:</strong> <?= date('F j, Y', strtotime($user['created_at'])) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>