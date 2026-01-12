<?php
require_once '../config/db.php';
requireLogin();
?>
<?php include '../includes/header.php'; ?>

<div class="dashboard-header">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
    <p>Alumni Dashboard</p>
</div>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="stat-content">
            <h3>5</h3>
            <p>Upcoming Events</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="stat-content">
            <h3>3</h3>
            <p>Active Applications</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-bullhorn"></i>
        </div>
        <div class="stat-content">
            <h3>12</h3>
            <p>New Announcements</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-network-wired"></i>
        </div>
        <div class="stat-content">
            <h3>1500+</h3>
            <p>Alumni Network</p>
        </div>
    </div>
</div>

<div class="dashboard-actions">
    <a href="profile.php" class="action-card">
        <i class="fas fa-user-edit"></i>
        <h3>Update Profile</h3>
        <p>Manage your personal information</p>
    </a>
    
    <a href="events.php" class="action-card">
        <i class="fas fa-calendar-check"></i>
        <h3>Events</h3>
        <p>Browse and register for events</p>
    </a>
    
    <a href="jobs.php" class="action-card">
        <i class="fas fa-search"></i>
        <h3>Job Search</h3>
        <p>Find career opportunities</p>
    </a>
    
    <a href="announcements.php" class="action-card">
        <i class="fas fa-newspaper"></i>
        <h3>Announcements</h3>
        <p>Latest updates from AIU</p>
    </a>
    
    <a href="applications.php" class="action-card">
        <i class="fas fa-file-alt"></i>
        <h3>Applications</h3>
        <p>Track your job applications</p>
    </a>
    
    <a href="feedback.php" class="action-card">
        <i class="fas fa-comments"></i>
        <h3>Feedback</h3>
        <p>Share your suggestions</p>
    </a>
</div>

<div class="recent-activity">
    <h2>Recent Activity</h2>
    <div class="activity-list">
        <div class="activity-item">
            <i class="fas fa-calendar-plus activity-icon"></i>
            <div class="activity-content">
                <p>Registered for "Career Workshop 2024"</p>
                <span class="activity-time">2 days ago</span>
            </div>
        </div>
        <div class="activity-item">
            <i class="fas fa-briefcase activity-icon"></i>
            <div class="activity-content">
                <p>Applied for "Software Engineer at TechCorp"</p>
                <span class="activity-time">5 days ago</span>
            </div>
        </div>
        <div class="activity-item">
            <i class="fas fa-comment activity-icon"></i>
            <div class="activity-content">
                <p>Submitted feedback on "AIU Annual Report"</p>
                <span class="activity-time">1 week ago</span>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>