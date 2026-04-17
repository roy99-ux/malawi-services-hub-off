<?php require_once 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - Malawi Service Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<div class="bg-secondary text-white py-4">
    <div class="container">
        <h1 class="display-5 fw-bold">Terms of Service</h1>
        <p class="lead">Last updated: <?= date('F j, Y') ?></p>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="sticky-top" style="top: 20px;">
                <div class="list-group">
                    <a href="#agreement" class="list-group-item list-group-item-action">1. Agreement to Terms</a>
                    <a href="#definitions" class="list-group-item list-group-item-action">2. Definitions</a>
                    <a href="#users" class="list-group-item list-group-item-action">3. User Accounts</a>
                    <a href="#providers" class="list-group-item list-group-item-action">4. Service Providers</a>
                    <a href="#customers" class="list-group-item list-group-item-action">5. Customers</a>
                    <a href="#bookings" class="list-group-item list-group-item-action">6. Bookings & Payments</a>
                    <a href="#prohibited" class="list-group-item list-group-item-action">7. Prohibited Conduct</a>
                    <a href="#termination" class="list-group-item list-group-item-action">8. Termination</a>
                    <a href="#liability" class="list-group-item list-group-item-action">9. Limitation of Liability</a>
                    <a href="#disputes" class="list-group-item list-group-item-action">10. Dispute Resolution</a>
                    <a href="#privacy" class="list-group-item list-group-item-action">11. Privacy Policy</a>
                    <a href="#changes" class="list-group-item list-group-item-action">12. Changes to Terms</a>
                    <a href="#contact" class="list-group-item list-group-item-action">13. Contact Us</a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    
                    <section id="agreement" class="mb-5">
                        <h2 class="h3 mb-3">1. Agreement to Terms</h2>
                        <p>By accessing or using the Malawi Service Marketplace website, mobile application, or any related services (collectively, the "Platform"), you agree to be bound by these Terms of Service ("Terms"). If you do not agree to these Terms, please do not use our Platform.</p>
                        <p>These Terms constitute a legally binding agreement between you and Malawi Service Marketplace ("Company," "we," "us," or "our"). You represent that you are at least 18 years old and have the legal capacity to enter into this agreement.</p>
                    </section>

                    <section id="definitions" class="mb-5">
                        <h2 class="h3 mb-3">2. Definitions</h2>
                        <ul class="list-unstyled">
                            <li><strong>"Customer"</strong> – A user who seeks to hire services through the Platform.</li>
                            <li><strong>"Service Provider"</strong> – A user who offers services through the Platform.</li>
                            <li><strong>"Booking"</strong> – An agreement between a Customer and a Service Provider for specific services.</li>
                            <li><strong>"Platform"</strong> – The website, mobile app, and all related services.</li>
                            <li><strong>"Content"</strong> – Any information, text, images, videos, or other material uploaded to the Platform.</li>
                        </ul>
                    </section>

                    <section id="users" class="mb-5">
                        <h2 class="h3 mb-3">3. User Accounts</h2>
                        <h5>3.1 Registration</h5>
                        <p>To use certain features of the Platform, you must register for an account. You agree to provide accurate, current, and complete information during registration and to update it promptly.</p>
                        
                        <h5>3.2 Account Security</h5>
                        <p>You are responsible for maintaining the confidentiality of your login credentials. You agree to notify us immediately of any unauthorized use of your account. We are not liable for any loss or damage arising from your failure to protect your account.</p>
                        
                        <h5>3.3 Account Types</h5>
                        <p>There are three types of accounts: Customer, Service Provider, and Administrator. Each account type has different permissions and responsibilities as outlined on the Platform.</p>
                    </section>

                    <section id="providers" class="mb-5">
                        <h2 class="h3 mb-3">4. Service Providers</h2>
                        <h5>4.1 Eligibility</h5>
                        <p>To become a Service Provider, you must complete your profile, including portfolio, skills, qualifications, and verification. We reserve the right to reject any application.</p>
                        
                        <h5>4.2 Profile Completion</h5>
                        <p>Service Providers must complete their profile before they can receive bookings. Incomplete profiles will not appear in search results.</p>
                        
                        <h5>4.3 Responsibility for Services</h5>
                        <p>Service Providers are solely responsible for the quality, legality, and delivery of their services. The Platform acts as a marketplace and does not endorse or guarantee any provider's work.</p>
                        
                        <h5>4.4 Pricing</h5>
                        <p>Service Providers set their own rates. Any negotiated price changes must be documented through the Platform's messaging system.</p>
                    </section>

                    <section id="customers" class="mb-5">
                        <h2 class="h3 mb-3">5. Customers</h2>
                        <h5>5.1 Service Requests</h5>
                        <p>Customers may request quotes from Service Providers. Requests must be made in good faith and with the intention of potentially hiring the provider.</p>
                        
                        <h5>5.2 Payment Obligations</h5>
                        <p>Customers agree to pay the agreed-upon amount for services rendered. Failure to pay may result in account suspension.</p>
                        
                        <h5>5.3 Reviews and Feedback</h5>
                        <p>Customers are encouraged to leave honest reviews. False or malicious reviews may result in account termination.</p>
                    </section>

                    <section id="bookings" class="mb-5">
                        <h2 class="h3 mb-3">6. Bookings & Payments</h2>
                        <h5>6.1 Booking Process</h5>
                        <p>Bookings are confirmed when both parties agree on price and scope of work. All negotiations must occur through the Platform's messaging system.</p>
                        
                        <h5>6.2 Mobile Money Payments</h5>
                        <p>Payments are processed through PayChangu (Airtel Money and TNM Mpamba). The Platform is not responsible for payment delays caused by third-party providers.</p>
                        
                        <h5>6.3 Refund Policy</h5>
                        <p>Refunds are handled on a case-by-case basis. Customers must dispute unsatisfactory work within 7 days of completion. The Platform may mediate disputes but is not liable for refunds.</p>
                        
                        <h5>6.4 Platform Fees</h5>
                        <p>Service Providers agree to pay a commission fee (currently 10%) on each completed booking. Fees are deducted automatically from payments.</p>
                    </section>

                    <section id="prohibited" class="mb-5">
                        <h2 class="h3 mb-3">7. Prohibited Conduct</h2>
                        <p>You agree NOT to:</p>
                        <ul>
                            <li>Use the Platform for any illegal purpose or in violation of Malawi laws.</li>
                            <li>Harass, abuse, or threaten other users.</li>
                            <li>Post false, misleading, or fraudulent information.</li>
                            <li>Attempt to complete transactions outside the Platform to avoid fees.</li>
                            <li>Upload malicious code, viruses, or harmful content.</li>
                            <li>Impersonate another person or entity.</li>
                            <li>Scrape, copy, or mine data from the Platform without permission.</li>
                        </ul>
                    </section>

                    <section id="termination" class="mb-5">
                        <h2 class="h3 mb-3">8. Termination</h2>
                        <p>We may suspend or terminate your account immediately, without notice, for conduct that violates these Terms or is harmful to the Platform or other users. You may delete your account at any time by contacting support.</p>
                        <p>Upon termination, your access to the Platform ceases, but any pending bookings or payment obligations remain in effect.</p>
                    </section>

                    <section id="liability" class="mb-5">
                        <h2 class="h3 mb-3">9. Limitation of Liability</h2>
                        <p>To the maximum extent permitted by law, Malawi Service Marketplace and its affiliates, directors, employees, or agents shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including loss of profits, data, or goodwill, arising from your use of the Platform.</p>
                        <p>Our total liability to you shall not exceed the amount you paid us in the 12 months preceding the claim.</p>
                        <p>We do not guarantee that the Platform will be uninterrupted, error-free, or secure.</p>
                    </section>

                    <section id="disputes" class="mb-5">
                        <h2 class="h3 mb-3">10. Dispute Resolution</h2>
                        <h5>10.1 Informal Resolution</h5>
                        <p>Before filing a formal claim, you agree to contact us to resolve any dispute informally.</p>
                        
                        <h5>10.2 Governing Law</h5>
                        <p>These Terms shall be governed by and construed in accordance with the laws of Malawi. Any legal action shall be brought exclusively in the courts of Lilongwe, Malawi.</p>
                        
                        <h5>10.3 Mediation</h5>
                        <p>Both parties agree to attempt mediation before arbitration or litigation.</p>
                    </section>

                    <section id="privacy" class="mb-5">
                        <h2 class="h3 mb-3">11. Privacy Policy</h2>
                        <p>Your privacy is important to us. Our <a href="privacy.php">Privacy Policy</a> explains how we collect, use, and protect your personal information. By using the Platform, you consent to our data practices as described in the Privacy Policy.</p>
                    </section>

                    <section id="changes" class="mb-5">
                        <h2 class="h3 mb-3">12. Changes to Terms</h2>
                        <p>We may modify these Terms at any time. If we make material changes, we will notify you via email or through the Platform. Your continued use of the Platform after changes become effective constitutes your acceptance of the revised Terms.</p>
                    </section>

                    <section id="contact" class="mb-5">
                        <h2 class="h3 mb-3">13. Contact Us</h2>
                        <p>If you have any questions about these Terms, please contact us:</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-envelope me-2"></i> legal@malawiserviceshub.mw</li>
                            <li><i class="fas fa-phone me-2"></i> +265 880 593 976</li>
                            <li><i class="fas fa-map-marker-alt me-2"></i> Blantyre, Malawi</li>
                        </ul>
                    </section>

                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle"></i> By using Malawi Service Marketplace, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>