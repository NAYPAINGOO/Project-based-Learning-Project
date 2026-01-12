<?php
require_once 'config/db.php';
?>
<?php include 'includes/header.php'; ?>

<div class="hero">
    <div class="hero-content">
        <h1>Welcome to AIU Alumni Portal</h1>
        <p>Connect, Network, and Grow with Your Alumni Community</p>
        <?php if (!isLoggedIn()): ?>
            <div class="hero-buttons">
                <a href="register.php" class="btn btn-primary">Join Now</a>
                <a href="login.php" class="btn btn-secondary">Login</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="features">
    <div class="feature-card">
        <i class="fas fa-calendar-alt feature-icon"></i>
        <h3>Events</h3>
        <p>Stay updated with alumni events, workshops, and reunions.</p>
    </div>
    <div class="feature-card">
        <i class="fas fa-briefcase feature-icon"></i>
        <h3>Jobs & Internships</h3>
        <p>Find career opportunities posted by companies and alumni.</p>
    </div>
    <div class="feature-card">
        <i class="fas fa-bullhorn feature-icon"></i>
        <h3>Announcements</h3>
        <p>Get the latest news and updates from AIU.</p>
    </div>
    <div class="feature-card">
        <i class="fas fa-users feature-icon"></i>
        <h3>Networking</h3>
        <p>Connect with fellow alumni and expand your professional network.</p>
    </div>
</div>

<div class="stats">
    <div class="stat-item">
        <h3>1500+</h3>
        <p>Registered Alumni</p>
    </div>
    <div class="stat-item">
        <h3>50+</h3>
        <p>Events Organized</p>
    </div>
    <div class="stat-item">
        <h3>200+</h3>
        <p>Job Opportunities</p>
    </div>
    <div class="stat-item">
        <h3>30+</h3>
        <p>Partner Companies</p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>