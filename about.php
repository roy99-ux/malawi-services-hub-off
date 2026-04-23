<?php require_once 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Malawi Service Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<div class="bg-success text-white py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">About Malawi Services Hub</h1>
        <p class="lead">Connecting Malawians with trusted local service providers</p>
    </div>
</div>

<!-- Mission & Vision -->
<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <i class="fas fa-bullseye fa-3x text-primary mb-3"></i>
                    <h3>Our Mission</h3>
                    <p class="text-muted">To empower Malawian communities by providing a reliable, easy-to-use platform that connects customers with skilled local service providers, fostering economic growth and trust.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <i class="fas fa-eye fa-3x text-success mb-3"></i>
                    <h3>Our Vision</h3>
                    <p class="text-muted">To become Malawi's most trusted digital marketplace for services, where every professional can grow their business and every customer finds quality service with confidence.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Story / Who We Are -->
<div class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="assets/images/about-story.jpg" alt="Malawi service marketplace story" class="img-fluid rounded shadow" onerror="this.src='https://via.placeholder.com/600x400?text=Malawi+Marketplace'">
            </div>
            <div class="col-md-6">
                <h2 class="mb-3">Who We Are</h2>
                <p>Malawi Service Marketplace was founded in 2025 with a simple idea: make it easy for Malawians to find and hire trusted local professionals. From plumbers and electricians to tutors and photographers, we bring together skilled providers and customers in a transparent, secure environment.</p>
                <p>We understand the challenges of finding reliable services in Malawi – that's why we built a platform that verifies providers, showcases their portfolios, and enables direct communication and mobile money payments.</p>
                <p>Our team is passionate about supporting local economies and leveraging technology to solve everyday problems. We are proud to be 100% Malawian-owned and operated.</p>
            </div>
        </div>
    </div>
</div>

<!-- Core Values -->
<div class="container py-5">
    <h2 class="text-center mb-5">Our Core Values</h2>
    <div class="row text-center g-4">
        <div class="col-md-3">
            <div class="p-3">
                <i class="fas fa-handshake fa-3x text-primary mb-2"></i>
                <h5>Trust</h5>
                <p class="small">We verify service providers and encourage client reviews.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3">
                <i class="fas fa-shield-alt fa-3x text-success mb-2"></i>
                <h5>Security</h5>
                <p class="small">Secure payments via Airtel Money & TNM Mpamba.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3">
                <i class="fas fa-chart-line fa-3x text-info mb-2"></i>
                <h5>Empowerment</h5>
                <p class="small">Helping local professionals grow their businesses.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3">
                <i class="fas fa-users fa-3x text-warning mb-2"></i>
                <h5>Community</h5>
                <p class="small">Building a stronger, more connected Malawi.</p>
            </div>
        </div>
    </div>
</div>

<!-- Team Section (sample) -->
<div class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5">Meet the Team</h2>
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <img src="assets/images/team1.jpg" class="rounded-circle mb-3" width="150" height="150" onerror="this.src='https://via.placeholder.com/150?text=Founder'">
                <h5>Roy Dziyanjanani</h5>
                <p class="text-muted">Founder & CEO</p>
                <p class="small">Tech entrepreneur passionate about connecting Malawians.</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <img src="assets/images/team2.jpg" class="rounded-circle mb-3" width="150" height="150" onerror="this.src='https://via.placeholder.com/150?text=CTO'">
                <h5>Roy Dziyanjanani</h5>
                <p class="text-muted">Lead Developer</p>
                <p class="small">Building the platform with modern web technologies.</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <img src="assets/images/team3.jpg" class="rounded-circle mb-3" width="150" height="150" onerror="this.src='https://via.placeholder.com/150?text=Support'">
                <h5>Shakira Misoya</h5>
                <p class="text-muted">Customer Support</p>
                <p class="small">Ensuring every user has a great experience.</p>
            </div>
        </div>
    </div>
</div>

<!-- Stats / Achievements -->
<!-- <div class="container py-5">
    <div class="row text-center">
        <div class="col-md-3">
            <h2 class="text-primary">500+</h2>
            <p>Service Providers</p>
        </div>
        <div class="col-md-3">
            <h2 class="text-primary">1,200+</h2>
            <p>Jobs Completed</p>
        </div>
        <div class="col-md-3">
            <h2 class="text-primary">10</h2>
            <p>Cities Covered</p>
        </div>
        <div class="col-md-3">
            <h2 class="text-primary">98%</h2>
            <p>Satisfied Customers</p>
        </div>
    </div>
</div> -->

<!-- Call to Action -->
<div class="bg-primary text-white py-5 text-center">
    <div class="container">
        <h3>Ready to find a trusted service provider?</h3>
        <p class="lead mb-3">Join your fellow Malawians who use our platform every day.</p>
        <a href="services.php" class="btn btn-light btn-lg">Browse Services</a>
        <?php if(!isLoggedIn()): ?>
            <a href="#" class="btn btn-outline-light btn-lg ms-2" data-bs-toggle="modal" data-bs-target="#registerModal">Sign Up Free</a>
        <?php endif; ?>
    </div>
</div>

<!-- Contact Info -->
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mx-auto text-center">
            <h3>Contact Us</h3>
            <p><i class="fas fa-map-marker-alt text-danger"></i> Blantyre, Malawi</p>
            <p><i class="fas fa-phone"></i> +265 880 593 976</p>
            <p><i class="fas fa-envelope"></i> malawiserviceshub@gmail.com</p>
            <div class="mt-3">
                <a href="#" class="text-dark me-3"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="#" class="text-dark me-3"><i class="fab fa-whatsapp fa-2x"></i></a>
                <a href="#" class="text-dark"><i class="fab fa-instagram fa-2x"></i></a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>