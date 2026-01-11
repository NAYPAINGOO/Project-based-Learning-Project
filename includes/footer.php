    </main>
    <!-- End of Main Content -->
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <!-- Column 1: Brand Info -->
                <div class="footer-col">
                    <div class="footer-logo">AIU ALUMNI.</div>
                    <p class="footer-address">
                        <i class="fas fa-map-marker-alt"></i>
                        Albukhary International University,<br>
                        Alor Setar, Kedah, Malaysia.
                    </p>
                    
                    <div class="social-links">
                        <a href="#" class="social-icon" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Column 2: Quick Links -->
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="events.php">Upcoming Events</a></li>
                        <li><a href="jobs.php">Job Board</a></li>
                        <li><a href="news.php">Latest News</a></li>
                    </ul>
                </div>
                
                <!-- Column 3: Resources -->
                <div class="footer-col">
                    <h4>Resources</h4>
                    <ul>
                        <li><a href="directory.php">Alumni Directory</a></li>
                        <li><a href="mentorship.php">Mentorship Program</a></li>
                        <li><a href="resources.php">Career Resources</a></li>
                        <li><a href="library.php">Digital Library</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                    </ul>
                </div>
                
                <!-- Column 4: University Links -->
                <div class="footer-col">
                    <h4>University</h4>
                    <ul>
                        <li><a href="https://aiu.edu.my" target="_blank">Main Website</a></li>
                        <li><a href="admissions.php">Admissions</a></li>
                        <li><a href="giving.php">Give Back</a></li>
                        <li><a href="research.php">Research</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
                
                <!-- Column 5: Contact Info -->
                <div class="footer-col">
                    <h4>Contact Info</h4>
                    <div class="contact-info">
                        <p>
                            <i class="fas fa-phone"></i>
                            <strong>Phone:</strong> +60 4-123 4567
                        </p>
                        <p>
                            <i class="fas fa-envelope"></i>
                            <strong>Email:</strong> alumni@aiu.edu.my
                        </p>
                        <p>
                            <i class="fas fa-clock"></i>
                            <strong>Office Hours:</strong><br>
                            Mon-Fri: 9AM-5PM (GMT+8)
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="copyright">
                    &copy; <?php echo date('Y'); ?> AIU Alumni Association. All Rights Reserved.
                </div>
                
                <div class="footer-links">
                    <a href="privacy.php">Privacy Policy</a>
                    <span class="separator">|</span>
                    <a href="terms.php">Terms of Service</a>
                    <span class="separator">|</span>
                    <a href="cookies.php">Cookie Policy</a>
                    <span class="separator">|</span>
                    <a href="accessibility.php">Accessibility</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Main JavaScript -->
    <script src="js/main.js"></script>
    
    <!-- Additional JavaScript Files -->
    <?php foreach($additional_js as $js_file): ?>
        <script src="<?php echo htmlspecialchars($js_file); ?>"></script>
    <?php endforeach; ?>
    
    <!-- Inline JavaScript for current page -->
    <script>
    // Mobile menu toggle
    document.querySelector('.mobile-menu-btn')?.addEventListener('click', function() {
        const navLinks = document.querySelector('.nav-links');
        navLinks.classList.toggle('active');
        this.innerHTML = navLinks.classList.contains('active') 
            ? '<i class="fas fa-times"></i>' 
            : '<i class="fas fa-bars"></i>';
    });
    
    // Back to top button
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', function() {
            backToTop.style.display = window.scrollY > 300 ? 'block' : 'none';
        });
        
        backToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const navLinks = document.querySelector('.nav-links');
        const mobileBtn = document.querySelector('.mobile-menu-btn');
        
        if (navLinks.classList.contains('active') && 
            !navLinks.contains(event.target) && 
            !mobileBtn.contains(event.target)) {
            navLinks.classList.remove('active');
            mobileBtn.innerHTML = '<i class="fas fa-bars"></i>';
        }
    });
    </script>
</body>
</html>
