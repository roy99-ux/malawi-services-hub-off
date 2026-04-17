<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

$providerId = (int)($_GET['id'] ?? 0);
if (!$providerId) die("Invalid provider");

// Fetch provider + portfolio
$stmt = getDb()->prepare("SELECT u.*, p.bio, p.experience_years, p.hourly_rate, p.location as provider_location, p.category_id, p.is_approved 
                          FROM users u 
                          JOIN portfolios p ON u.id = p.user_id 
                          WHERE u.id = ? AND u.role='provider' AND u.is_active=1");
$stmt->execute([$providerId]);
$provider = $stmt->fetch();
if (!$provider) die("Provider not found");

// Skills
$skills = getDb()->prepare("SELECT skill_name FROM skills WHERE portfolio_id = (SELECT id FROM portfolios WHERE user_id=?)");
$skills->execute([$providerId]);

// Qualifications
$quals = getDb()->prepare("SELECT degree, institution, year FROM qualifications WHERE portfolio_id = (SELECT id FROM portfolios WHERE user_id=?)");
$quals->execute([$providerId]);

// Projects (with images/videos)
$projects = getDb()->prepare("SELECT * FROM projects WHERE portfolio_id = (SELECT id FROM portfolios WHERE user_id=?) ORDER BY completion_date DESC");
$projects->execute([$providerId]);

// Testimonials (approved only)
$testimonials = getDb()->prepare("SELECT * FROM testimonials WHERE portfolio_id = (SELECT id FROM portfolios WHERE user_id=?) AND is_approved=1 ORDER BY created_at DESC LIMIT 5");
$testimonials->execute([$providerId]);

// Category name
$catName = '';
$catStmt = getDb()->prepare("SELECT name FROM service_categories WHERE id = ?");
$catStmt->execute([$provider['category_id']]);
$catName = $catStmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($provider['name']) ?> – Professional <?= $catName ?> in <?= $provider['provider_location'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .portfolio-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 60px 0; }
        .project-card { transition: transform 0.3s; margin-bottom: 20px; }
        .project-card:hover { transform: translateY(-5px); }
        .testimonial-card { border-left: 4px solid #28a745; background: #f8f9fa; }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="portfolio-header text-center">
    <div class="container">
        <img src="<?= $provider['profile_pic'] ?: 'assets/default-avatar.png' ?>" class="rounded-circle mb-3 border border-3 border-white" width="140" height="140" style="object-fit: cover;">
        <h1 class="display-5"><?= htmlspecialchars($provider['name']) ?></h1>
        <p class="lead"><?= htmlspecialchars($provider['bio'] ?: 'Professional ' . $catName) ?></p>
        <div class="mt-3">
            <span class="badge bg-light text-dark me-2"><i class="fas fa-map-marker-alt"></i> <?= $provider['provider_location'] ?></span>
            <span class="badge bg-light text-dark me-2"><i class="fas fa-tag"></i> <?= $catName ?></span>
            <span class="badge bg-light text-dark"><i class="fas fa-clock"></i> <?= $provider['experience_years'] ?>+ years exp</span>
        </div>
        <div class="mt-4">
            <?php if (isLoggedIn() && getCurrentUser()['role'] == 'customer'): ?>
                <a href="booking.php?provider=<?= $providerId ?>" class="btn btn-success btn-lg"><i class="fas fa-handshake"></i> Request Quote</a>
            <?php elseif (!isLoggedIn()): ?>
                <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#loginModal">Login to Request Quote</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <!-- Left column: Skills & Qualifications -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-code"></i> Skills</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <?php while($s = $skills->fetch()): ?>
                            <li><i class="fas fa-check-circle text-success me-2"></i> <?= htmlspecialchars($s['skill_name']) ?></li>
                        <?php endwhile; ?>
                        <?php if($skills->rowCount() == 0): ?>
                            <li class="text-muted">No skills listed yet.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-graduation-cap"></i> Qualifications</h5>
                </div>
                <div class="card-body">
                    <?php while($q = $quals->fetch()): ?>
                        <div class="mb-2">
                            <strong><?= htmlspecialchars($q['degree']) ?></strong><br>
                            <small><?= htmlspecialchars($q['institution']) ?>, <?= $q['year'] ?></small>
                        </div>
                    <?php endwhile; ?>
                    <?php if($quals->rowCount() == 0): ?>
                        <p class="text-muted">No qualifications listed.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right column: Projects & Testimonials -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-folder-open"></i> Recent Projects</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $hasProjects = false; while($proj = $projects->fetch()): $hasProjects = true; ?>
                            <div class="col-md-6 project-card">
                                <div class="card h-100">
                                    <?php 
                                    $images = explode(',', $proj['images']);
                                    if(!empty($images[0])): ?>
                                        <img src="<?= BASE_URL . $images[0] ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="<?= htmlspecialchars($proj['title']) ?>">
                                    <?php else: ?>
                                        <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 180px;"><i class="fas fa-image fa-3x"></i></div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h6 class="card-title"><?= htmlspecialchars($proj['title']) ?></h6>
                                        <p class="small text-muted"><?= htmlspecialchars(substr($proj['description'], 0, 80)) ?>...</p>
                                        <?php if(!empty($proj['videos'])): ?>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal-<?= $proj['id'] ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-play"></i> Watch Video</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Video Modal -->
                            <div class="modal fade" id="videoModal-<?= $proj['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><?= htmlspecialchars($proj['title']) ?> – Video</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <video controls class="w-100">
                                                <source src="<?= BASE_URL . explode(',', $proj['videos'])[0] ?>" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php if(!$hasProjects): ?>
                            <p class="text-muted">No projects uploaded yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-star"></i> What Clients Say</h5>
                </div>
                <div class="card-body">
                    <?php while($t = $testimonials->fetch()): ?>
                        <div class="testimonial-card p-3 mb-3 rounded">
                            <div class="text-warning mb-2">
                                <?php for($i=1;$i<=5;$i++) echo $i<=$t['rating'] ? '★' : '☆'; ?>
                            </div>
                            <p class="mb-1">"<?= htmlspecialchars($t['text']) ?>"</p>
                            <small class="text-muted">– <?= htmlspecialchars($t['client_name']) ?></small>
                        </div>
                    <?php endwhile; ?>
                    <?php if($testimonials->rowCount() == 0): ?>
                        <p class="text-muted">No testimonials yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>