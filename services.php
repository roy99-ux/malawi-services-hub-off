<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

$location = $_GET['location'] ?? '';
$categoryId = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';

$query = "SELECT u.*, p.hourly_rate, p.experience_years, p.is_approved, 
          (SELECT AVG(rating) FROM bookings WHERE provider_id = u.id AND rating IS NOT NULL) as avg_rating
          FROM users u 
          JOIN portfolios p ON u.id = p.user_id 
          WHERE u.role = 'provider' AND u.is_active = 1 AND p.is_approved = 1";

$params = [];
if ($location) {
    $query .= " AND u.location = ?";
    $params[] = $location;
}
if ($categoryId) {
    $query .= " AND p.category_id = ?";
    $params[] = $categoryId;
}
if ($search) {
    $query .= " AND (u.name LIKE ? OR p.bio LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
$query .= " ORDER BY avg_rating DESC, u.created_at DESC";

$stmt = getDb()->prepare($query);
$stmt->execute($params);
$providers = $stmt->fetchAll();

// Get category name for title
$categoryName = '';
if ($categoryId) {
    $catStmt = getDb()->prepare("SELECT name FROM service_categories WHERE id = ?");
    $catStmt->execute([$categoryId]);
    $categoryName = $catStmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Find Services in <?= htmlspecialchars($location ?: 'Malawi') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active"><?= $categoryName ?: 'All Services' ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Filter Providers</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="">
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <select name="location" class="form-select">
                                <option value="">All Locations</option>
                                <?php
                                $locations = ['Lilongwe','Blantyre','Mzuzu','Zomba','Balaka','Chikwawa','Chiradzulu','Chitipa','Dedza','Dowa','Karonga','Kasungu','Machinga','Mangochi','Mchinji',
                                'Mulanje','Mwanza','Mzimba','Neno','Nkhatabay','Nkhotakota','Nsanje','Ntcheu','Ntchisi','Phalombe','Rumphi','Salima','Thyolo'];
                                foreach($locations as $loc) {
                                    $selected = ($location == $loc) ? 'selected' : '';
                                    echo "<option value='$loc' $selected>$loc</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                <?php
                                $cats = getDb()->query("SELECT id, name FROM service_categories WHERE is_active=1");
                                while($cat = $cats->fetch()) {
                                    $selected = ($categoryId == $cat['id']) ? 'selected' : '';
                                    echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Search by name</label>
                            <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($search) ?>" placeholder="e.g., John">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4><?= count($providers) ?> provider(s) found</h4>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Sort by</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?sort=rating">Rating</a></li>
                        <li><a class="dropdown-item" href="?sort=price_low">Price: Low to High</a></li>
                        <li><a class="dropdown-item" href="?sort=price_high">Price: High to Low</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <?php if (empty($providers)): ?>
                    <div class="col-12">
                        <div class="alert alert-info">No providers found. Try adjusting your filters.</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($providers as $provider): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm hover-shadow">
                                <img src="<?= $provider['profile_pic'] ?: 'assets/default-avatar.png' ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="Profile">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($provider['name']) ?></h5>
                                    <div class="text-warning mb-2">
                                        <?php 
                                        $rating = round($provider['avg_rating'] ?? 0);
                                        for($i=1;$i<=5;$i++) echo $i<=$rating ? '★' : '☆';
                                        ?>
                                        <span class="text-muted">(<?= number_format($provider['avg_rating'] ?? 0,1) ?>)</span>
                                    </div>
                                    <p class="card-text"><i class="fas fa-map-marker-alt text-danger"></i> <?= $provider['location'] ?></p>
                                    <p class="card-text"><i class="fas fa-briefcase"></i> <?= $provider['experience_years'] ?? 0 ?> years exp</p>
                                    <p class="card-text fw-bold text-success">MWK <?= number_format($provider['hourly_rate'] ?? 5000) ?> / hr</p>
                                    <a href="service-details.php?id=<?= $provider['id'] ?>" class="btn btn-primary w-100">View Profile</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>