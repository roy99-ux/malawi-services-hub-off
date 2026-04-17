<!-- Footer -->
<footer class="bg-dark text-white mt-5 pt-4 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5>Malawi Services Marketplace</h5>
                <p>Connecting Malawians with trusted service providers across the country.</p>
                <div class="mt-3">
                    <a href="#" class="text-white me-2"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-whatsapp fa-lg"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin fa-lg"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="<?= BASE_URL ?>index.php" class="text-white-50 text-decoration-none">Home</a></li>
                    <li><a href="<?= BASE_URL ?>services.php" class="text-white-50 text-decoration-none">Find Services</a></li>
                    <li><a href="<?= BASE_URL ?>how-it-works.php" class="text-white-50 text-decoration-none">How It Works</a></li>
                    <li><a href="<?= BASE_URL ?>about.php" class="text-white-50 text-decoration-none">About Us</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-3">
                <h6>For Professionals</h6>
                <ul class="list-unstyled">
                    <li><a href="<?= BASE_URL ?>api/register.php" class="text-white-50 text-decoration-none">Become a Provider</a></li>
                    <li><a href="<?= BASE_URL ?>provider/dashboard.php" class="text-white-50 text-decoration-none">Provider Dashboard</a></li>
                    <li><a href="<?= BASE_URL ?>provider/portfolio.php" class="text-white-50 text-decoration-none">Build Portfolio</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-3">
                <h6>Contact Us</h6>
                <ul class="list-unstyled">
                    <li><a href="tel:+265880593976"><i class="fas fa-phone me-2"></i> +265 880 593 976</a></li>
                    <li><a href="mailto:malawiserviceshub@gmail.com"><i class="fas fa-envelope me-2"></i> malawiserviceshub@gmail.com</a></li>
                    <li><i class="fas fa-map-marker-alt me-2"></i> Blantyre, Malawi</li>
                </ul>
            </div>
        </div>
        <hr class="bg-secondary">
        <div class="text-center">
            <small>&copy; <?= date('Y') ?> Malawi Service Marketplace. All rights reserved.</small>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery (for AJAX) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Global functions
function showToast(message, type = 'success') {
    // You can implement a toast notification system here
    alert(message);
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() { alert.remove(); }, 500);
        });
    }, 5000);
});
</script>
</body>
</html>