    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>AIU Alumni Portal</h3>
                <p>Connecting graduates with opportunities and the AIU community.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <a href="../index.php">Home</a>
                <a href="../about.php">About</a>
                <a href="../contact.php">Contact</a>
                <?php if (isLoggedIn()): ?>
                    <a href="../user/dashboard.php">Dashboard</a>
                <?php endif; ?>
            </div>
            <div class="footer-section">
                <h3>Contact Info</h3>
                <p><i class="fas fa-map-marker-alt"></i> Albukhary International University</p>
                <p><i class="fas fa-phone"></i> +60 4-123 4567</p>
                <p><i class="fas fa-envelope"></i> alumni@aiu.edu.my</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> AIU Alumni Portal. All rights reserved.</p>
        </div>
    </footer>

    <script src="../assets/script.js"></script>
</body>
</html>