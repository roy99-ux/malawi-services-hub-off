<?php require_once 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Malawi Service Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<div class="bg-info text-white py-4">
    <div class="container">
        <h1 class="display-5 fw-bold">Privacy Policy</h1>
        <p class="lead">Last updated: <?= date('F j, Y') ?></p>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="sticky-top" style="top: 20px;">
                <div class="list-group">
                    <a href="#intro" class="list-group-item list-group-item-action">1. Introduction</a>
                    <a href="#information" class="list-group-item list-group-item-action">2. Information We Collect</a>
                    <a href="#usage" class="list-group-item list-group-item-action">3. How We Use Your Information</a>
                    <a href="#sharing" class="list-group-item list-group-item-action">4. Sharing of Information</a>
                    <a href="#cookies" class="list-group-item list-group-item-action">5. Cookies & Tracking</a>
                    <a href="#security" class="list-group-item list-group-item-action">6. Data Security</a>
                    <a href="#retention" class="list-group-item list-group-item-action">7. Data Retention</a>
                    <a href="#rights" class="list-group-item list-group-item-action">8. Your Rights</a>
                    <a href="#children" class="list-group-item list-group-item-action">9. Children's Privacy</a>
                    <a href="#thirdparty" class="list-group-item list-group-item-action">10. Third-Party Links</a>
                    <a href="#changes" class="list-group-item list-group-item-action">11. Changes to Policy</a>
                    <a href="#contact" class="list-group-item list-group-item-action">12. Contact Us</a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    
                    <section id="intro" class="mb-5">
                        <h2 class="h3 mb-3">1. Introduction</h2>
                        <p>Welcome to Malawi Service Marketplace ("we," "our," "us"). We are committed to protecting your personal information and your right to privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our website, mobile application, and services (collectively, the "Platform").</p>
                        <p>By using our Platform, you consent to the data practices described in this policy. If you do not agree, please do not use our Platform.</p>
                    </section>

                    <section id="information" class="mb-5">
                        <h2 class="h3 mb-3">2. Information We Collect</h2>
                        <h5>2.1 Personal Information You Provide</h5>
                        <p>We collect information you voluntarily provide when you:</p>
                        <ul>
                            <li>Register for an account (name, email, phone number, location)</li>
                            <li>Create a provider portfolio (skills, qualifications, projects, bio, hourly rate)</li>
                            <li>Make a booking or request a quote</li>
                            <li>Communicate with other users via our messaging system</li>
                            <li>Submit reviews or testimonials</li>
                            <li>Contact customer support</li>
                        </ul>
                        
                        <h5>2.2 Information Automatically Collected</h5>
                        <p>When you use our Platform, we automatically collect:</p>
                        <ul>
                            <li><strong>Device Information:</strong> IP address, browser type, operating system, device identifiers</li>
                            <li><strong>Usage Data:</strong> Pages visited, time spent, search queries, referral URLs</li>
                            <li><strong>Location Data:</strong> Approximate location based on IP address</li>
                            <li><strong>Cookies:</strong> See Section 5 below</li>
                        </ul>
                        
                        <h5>2.3 Payment Information</h5>
                        <p>All payments are processed through PayChangu (Airtel Money, TNM Mpamba). We do not store your mobile money account numbers or transaction PINs. PayChangu's privacy policy applies to payment data.</p>
                    </section>

                    <section id="usage" class="mb-5">
                        <h2 class="h3 mb-3">3. How We Use Your Information</h2>
                        <p>We use your information for the following purposes:</p>
                        <ul>
                            <li><strong>To provide and maintain the Platform:</strong> Create accounts, match customers with providers, process bookings, and enable messaging.</li>
                            <li><strong>To improve our services:</strong> Analyze usage patterns, fix bugs, and enhance user experience.</li>
                            <li><strong>To communicate with you:</strong> Send booking confirmations, notifications, updates, and promotional offers (you may opt out).</li>
                            <li><strong>To ensure safety and security:</strong> Detect fraud, enforce our Terms of Service, and prevent prohibited activities.</li>
                            <li><strong>To comply with legal obligations:</strong> Respond to lawful requests from authorities.</li>
                        </ul>
                    </section>

                    <section id="sharing" class="mb-5">
                        <h2 class="h3 mb-3">4. Sharing of Information</h2>
                        <p>We do not sell your personal information. We may share your information in the following circumstances:</p>
                        <ul>
                            <li><strong>With Service Providers:</strong> When you book a service, your name, phone number, and location are shared with the provider to facilitate the job.</li>
                            <li><strong>With Customers:</strong> Providers' portfolio details are visible to customers. Messaging exchanges are visible to both parties.</li>
                            <li><strong>With Payment Processors:</strong> PayChangu receives transaction data to process mobile money payments.</li>
                            <li><strong>For Legal Reasons:</strong> If required by law, court order, or to protect our rights, property, or safety.</li>
                            <li><strong>With Your Consent:</strong> We may share information for other purposes if you give explicit consent.</li>
                        </ul>
                    </section>

                    <section id="cookies" class="mb-5">
                        <h2 class="h3 mb-3">5. Cookies & Tracking</h2>
                        <p>We use cookies and similar tracking technologies to:</p>
                        <ul>
                            <li>Keep you logged in (session cookies)</li>
                            <li>Remember your preferences</li>
                            <li>Analyze site traffic (Google Analytics or similar)</li>
                            <li>Serve relevant advertisements (if applicable)</li>
                        </ul>
                        <p>You can control cookies through your browser settings. Disabling cookies may affect Platform functionality.</p>
                        <p>Third-party services (like Pusher for real-time chat, PayChangu for payments) may also use cookies subject to their own policies.</p>
                    </section>

                    <section id="security" class="mb-5">
                        <h2 class="h3 mb-3">6. Data Security</h2>
                        <p>We implement reasonable security measures to protect your information, including:</p>
                        <ul>
                            <li>Encryption of passwords and sensitive data</li>
                            <li>Secure HTTPS connections</li>
                            <li>Regular security audits</li>
                            <li>Access controls for employees and administrators</li>
                        </ul>
                        <p>However, no method of transmission over the Internet is 100% secure. We cannot guarantee absolute security. You are responsible for keeping your login credentials confidential.</p>
                    </section>

                    <section id="retention" class="mb-5">
                        <h2 class="h3 mb-3">7. Data Retention</h2>
                        <p>We retain your personal information for as long as your account is active or as needed to provide services. After account deletion, we may retain certain information for legal, tax, or fraud prevention purposes (e.g., transaction records for 5 years). You can request deletion of your data by contacting us.</p>
                    </section>

                    <section id="rights" class="mb-5">
                        <h2 class="h3 mb-3">8. Your Rights</h2>
                        <p>Depending on your location (including Malawi), you may have the following rights:</p>
                        <ul>
                            <li><strong>Access:</strong> Request a copy of your personal data.</li>
                            <li><strong>Correction:</strong> Update inaccurate or incomplete information.</li>
                            <li><strong>Deletion:</strong> Request deletion of your data (subject to legal obligations).</li>
                            <li><strong>Objection:</strong> Opt out of marketing communications.</li>
                            <li><strong>Data Portability:</strong> Receive your data in a structured format.</li>
                        </ul>
                        <p>To exercise these rights, contact us at privacy@malawiservicehub.mw. We will respond within 30 days.</p>
                    </section>

                    <section id="children" class="mb-5">
                        <h2 class="h3 mb-3">9. Children's Privacy</h2>
                        <p>Our Platform is not intended for children under 18 years of age. We do not knowingly collect personal information from minors. If you believe a child has provided us with data, please contact us, and we will delete it.</p>
                    </section>

                    <section id="thirdparty" class="mb-5">
                        <h2 class="h3 mb-3">10. Third-Party Links</h2>
                        <p>The Platform may contain links to external websites (e.g., PayChangu, social media). We are not responsible for the privacy practices of those sites. Please read their privacy policies.</p>
                    </section>

                    <section id="changes" class="mb-5">
                        <h2 class="h3 mb-3">11. Changes to This Policy</h2>
                        <p>We may update this Privacy Policy from time to time. We will notify you of material changes by email or through a notice on the Platform. The "Last updated" date at the top of this page indicates when the policy was last revised. Your continued use after changes constitutes acceptance.</p>
                    </section>

                    <section id="contact" class="mb-5">
                        <h2 class="h3 mb-3">12. Contact Us</h2>
                        <p>If you have questions or concerns about this Privacy Policy or our data practices, please contact us:</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-envelope me-2"></i> privacy@malawiservicehub.mw</li>
                            <li><i class="fas fa-phone me-2"></i> +265 888 123 456</li>
                            <li><i class="fas fa-map-marker-alt me-2"></i> Lilongwe, Malawi</li>
                            <li><i class="fas fa-user-shield me-2"></i> Data Protection Officer: dpo@malawiservicehub.mw</li>
                        </ul>
                    </section>

                    <div class="alert alert-warning mt-4">
                        <i class="fas fa-exclamation-triangle"></i> <strong>Important:</strong> This Privacy Policy applies only to information collected through the Malawi Service Marketplace Platform. We encourage you to review this policy periodically.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>