<?php require_once 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malawi Service Marketplace - Find Trusted Local Service Providers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<div class="hero-section bg-gradient text-white py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-8">
                <h1 style="color: teal" class="display-4 fw-bold mb-3">Find Trusted Service Providers in Malawi</h1>
                <p class="lead mb-4 text-dark" color>Connect with skilled professionals near you. From plumbing to tutoring, get quality services at fair prices.</p>
                
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label text-dark fw-bold">📍 Your Location</label>
                                <select id="locationSelect" class="form-select form-select-lg">
                                    <option value="">Select city/district</option>
                                    <option value="Lilongwe">Lilongwe</option>
                                    <option value="Blantyre">Blantyre</option>
                                    <option value="Mzuzu">Mzuzu</option>
                                    <option value="Zomba">Zomba</option>
                                    <option value="Balaka">Balaka</option>
                                    <option value="Chikwawa">Chikwawa</option>
                                    <option value="Chiradzulu">Chiradzulu</option>
                                    <option value="Chitipa">Chitipa</option>
                                    <option value="Dedza">Dedza</option>
                                    <option value="Dowa">Dowa</option>
                                    <option value="Karonga">Karonga</option>
                                    <option value="Kasungu">Kasungu</option>
                                    <option value="Machinga">Machinga</option>
                                    <option value="Mangochi">Mangochi</option>
                                    <option value="Mchinji">Mchinji</option>
                                    <option value="Mulanje">Mulanje</option>
                                    <option value="Mwanza">Mwanza</option>
                                    <option value="Mzimba">Mzimba</option>
                                    <option value="Neno">Neno</option>
                                    <option value="Nkhatabay">Nkhatabay</option>
                                    <option value="Nkhotakota">Nkhotakota</option>
                                    <option value="Nsanje">Nsanje</option>
                                    <option value="Ntcheu">Ntcheu</option>
                                    <option value="Ntchisi">Ntchisi</option>
                                    <option value="Phalombe">Phalombe</option>
                                    <option value="Rumphi">Rumphi</option>
                                    <option value="Salima">Salima</option>
                                    <option value="Thyolo">Thyolo</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label text-dark fw-bold">🔧 Service Needed</label>
                                <select id="categorySelect" class="form-select form-select-lg">
                                    <option value="">Select service category</option>
                                    <?php
                                    $cats = getDb()->query("SELECT * FROM service_categories WHERE is_active=1 ORDER BY name");
                                    while($cat = $cats->fetch()) {
                                        echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button class="btn btn-success btn-lg w-100" onclick="searchServices()">
                                    <i class="fas fa-search"></i> Find
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- How It Works -->
<div class="container py-5">
    <h2 class="text-center mb-5">How It Works</h2>
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-search fa-2x"></i>
                    </div>
                    <h5>1. Find a Service</h5>
                    <p>Search by location and category to find qualified service providers near you.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-comments fa-2x"></i>
                    </div>
                    <h5>2. Get a Quote</h5>
                    <p>Chat with providers, negotiate prices, and agree on terms.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <h5>3. Book & Pay</h5>
                    <p>Confirm booking and pay securely via mobile money (Airtel/TNM).</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popular Categories -->
<div class="container py-5 bg-light">
    <h2 class="text-center mb-4">Popular Service Categories</h2>
    <div class="row">
        <?php
        $stmt = getDb()->query("SELECT * FROM service_categories WHERE is_active=1 LIMIT 10");
        while($cat = $stmt->fetch()) {
            echo "<div class='col-md-2 col-6 mb-3'>
                    <a href=\"services.php?category=" . $cat['id'] . "\" class='text-decoration-none'>
                        <div class='category-card text-center p-3 bg-white rounded shadow-sm'>
                            <i class='fas fa-" . ($cat['icon'] ?: 'service') . " fa-3x text-primary mb-2'></i>
                            <h6 class='mb-0'>" . htmlspecialchars($cat['name']) . "</h6>
                            <small class='text-muted'>Find providers</small>
                        </div>
                    </a>
                  </div>";

        }
        ?>
    </div>
</div>

<!-- Featured Providers -->
<div class="container py-5">
    <h2 class="text-center mb-4">Top Rated Providers</h2>
    <div class="row">
        <?php
        $providers = getDb()->query("SELECT u.*, p.hourly_rate, AVG(b.rating) as avg_rating 
                                     FROM users u 
                                     JOIN portfolios p ON u.id = p.user_id 
                                     LEFT JOIN bookings b ON b.provider_id = u.id 
                                     WHERE u.role='provider' AND u.is_active=1 AND p.is_approved=1
                                     GROUP BY u.id 
                                     ORDER BY avg_rating DESC 
                                     LIMIT 6");
        while($provider = $providers->fetch()):
        ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?= $provider['profile_pic'] ?? 'assets/default-avatar.png' ?>" class="rounded-circle me-3" width="60" height="60">
                        <div>
                            <h5 class="card-title mb-0"><?= htmlspecialchars($provider['name']) ?></h5>
                            <div class="text-warning">
                                <?php 
                                $rating = round($provider['avg_rating'] ?? 0);
                                for($i=1; $i<=5; $i++) {
                                    echo $i <= $rating ? '★' : '☆';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <p class="card-text"><i class="fas fa-map-marker-alt text-danger"></i> <?= $provider['location'] ?></p>
                    <p class="card-text"><i class="fas fa-clock"></i> <?= $provider['experience_years'] ?? 0 ?> years exp</p>
                    <p class="card-text fw-bold text-success">From MWK <?= number_format($provider['hourly_rate'] ?? 5000) ?> / hr</p>
                    <a href="service-details.php?id=<?= $provider['id'] ?>" class="btn btn-primary w-100">View Profile</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Call to Action -->
<div class="bg-primary text-white py-5">
    <div class="container text-center">
        <h3>Are you a service provider?</h3>
        <p class="lead">Join your fellow professionals earning on our platform</p>
        <?php if(!isLoggedIn()): ?>
            <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#registerModal" onclick="document.querySelector('input[value=provider]').checked=true">
                Become a Provider
            </button>
        <?php else: ?>
            <a href="provider/portfolio.php" class="btn btn-light btn-lg">Complete Your Profile</a>
        <?php endif; ?>
    </div>
</div>

<script>
function searchServices() {
    let loc = document.getElementById('locationSelect').value;
    let cat = document.getElementById('categorySelect').value;
    if(!loc || !cat) {
        alert('Please select both location and service category');
        return;
    }
    window.location.href = `services.php?location=${encodeURIComponent(loc)}&category=${cat}`;
}
</script>

<?php include 'includes/footer.php'; ?>
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-sign-in-alt me-2"></i>Login to Your Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="loginAlert"></div>
                <form id="loginForm">
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember Me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <hr>
                <div class="text-center">
                    <a href="#" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#forgotPasswordModal">Forgot Password?</a>
                    <br>
                    <small>Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#registerModal">Register here</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Create Your Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="registerAlert"></div>
                <form id="registerForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control" required>
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number *</label>
                            <input type="tel" name="phone" class="form-control" required placeholder="+265 888 123 456">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location *</label>
                            <select name="location" class="form-select" required>
                                <option value="">Select your city/town</option>
                                <option value="Lilongwe">Lilongwe</option>
                                <option value="Blantyre">Blantyre</option>
                                <option value="Mzuzu">Mzuzu</option>
                                <option value="Zomba">Zomba</option>
                                <option value="Balaka">Balaka</option>
                                <option value="Chikwawa">Chikwawa</option>
                                <option value="Chiradzulu">Chiradzulu</option>
                                <option value="Chitipa">Chitipa</option>
                                <option value="Dedza">Dedza</option>
                                <option value="Dowa">Dowa</option>
                                <option value="Karonga">Karonga</option>
                                <option value="Kasungu">Kasungu</option>
                                <option value="Machinga">Machinga</option>
                                <option value="Mangochi">Mangochi</option>
                                <option value="Mchinji">Mchinji</option>
                                <option value="Mulanje">Mulanje</option>
                                <option value="Mwanza">Mwanza</option>
                                <option value="Mzimba">Mzimba</option>
                                <option value="Neno">Neno</option>
                                <option value="Nkhatabay">Nkhatabay</option>
                                <option value="Nkhotakota">Nkhotakota</option>
                                <option value="Nsanje">Nsanje</option>
                                <option value="Ntcheu">Ntcheu</option>
                                <option value="Ntchisi">Ntchisi</option>
                                <option value="Phalombe">Phalombe</option>
                                <option value="Rumphi">Rumphi</option>
                                <option value="Salima">Salima</option>
                                <option value="Thyolo">Thyolo</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">I want to join as *</label>
                            <div class="form-check">
                                <input type="radio" name="role" value="customer" class="form-check-input" id="roleCustomer" checked>
                                <label class="form-check-label" for="roleCustomer">
                                    <i class="fas fa-user"></i> Customer - Find services
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="role" value="provider" class="form-check-input" id="roleProvider">
                                <label class="form-check-label" for="roleProvider">
                                    <i class="fas fa-briefcase"></i> Service Provider - Offer my services
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="termsCheck" required>
                        <label class="form-check-label" for="termsCheck">
                            I agree to the <a href="#" target="_blank">Terms of Service</a> and <a href="#" target="_blank">Privacy Policy</a>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Register Now</button>
                </form>
                <hr>
                <div class="text-center">
                    <small>Already have an account? <a href="#" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loginModal">Login here</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="forgotAlert"></div>
                <p>Enter your email address and we'll send you a link to reset your password.</p>
                <form id="forgotForm">
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Login form handler
$('#loginForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: 'api/login.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                window.location.href = response.redirect;
            } else {
                $('#loginAlert').html('<div class="alert alert-danger">' + response.message + '</div>');
            }
        },
        error: function() {
            $('#loginAlert').html('<div class="alert alert-danger">Network error. Please try again.</div>');
        }
    });
});

// Register form handler
$('#registerForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: 'api/register.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                $('#registerAlert').html('<div class="alert alert-success">' + response.message + '</div>');
                setTimeout(function() {
                    $('#registerModal').modal('hide');
                    $('#loginModal').modal('show');
                }, 2000);
            } else {
                $('#registerAlert').html('<div class="alert alert-danger">' + response.message + '</div>');
            }
        },
        error: function() {
            $('#registerAlert').html('<div class="alert alert-danger">Network error. Please try again.</div>');
        }
    });
});

// Forgot password handler
$('#forgotForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: 'api/forgot_password.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            const alert = $('<div>')
                .addClass('alert ' + (response.success ? 'alert-success' : 'alert-danger'))
                .text(response.message);
            $('#forgotAlert').empty().append(alert);
            if (response.success) {
                setTimeout(function() {
                    $('#forgotPasswordModal').modal('hide');
                }, 3000);
            }
        },
        error: function(xhr) {
            const message = xhr.responseJSON && xhr.responseJSON.message
                ? xhr.responseJSON.message
                : 'Unable to process the request. Please try again.';
            $('#forgotAlert').empty().append(
                $('<div>').addClass('alert alert-danger').text(message)
            );
        }
    });
});

// Auto-show modals based on URL parameters
$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.get('show') === 'login') {
        $('#loginModal').modal('show');
    } else if(urlParams.get('show') === 'register') {
        $('#registerModal').modal('show');
    }
});
</script>
</body>
</html>