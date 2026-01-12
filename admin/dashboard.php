<?php
require_once '../config/db.php';
requireAdmin();

$conn = getDBConnection();

// Get dashboard statistics
$stats_sql = "SELECT 
    (SELECT COUNT(*) FROM ALUMNI) as total_alumni,
    (SELECT COUNT(*) FROM ACCOUNT WHERE account_status = 'Pending') as pending_accounts,
    (SELECT COUNT(*) FROM EVENT WHERE event_date >= CURDATE()) as upcoming_events,
    (SELECT COUNT(*) FROM JOB WHERE closing_date >= CURDATE() OR closing_date IS NULL) as active_jobs,
    (SELECT COUNT(*) FROM FEEDBACK WHERE status = 'Pending') as pending_feedback,
    (SELECT COUNT(*) FROM COMPANY) as total_companies";

$stats_result = $conn->query($stats_sql);
$stats = $stats_result->fetch_assoc();

// Get recent registrations
$recent_alumni_sql = "SELECT a.*, p.program_name, ac.account_status 
                     FROM ALUMNI a 
                     LEFT JOIN PROGRAM p ON a.program_id = p.program_id 
                     LEFT JOIN ACCOUNT ac ON a.alumni_id = ac.alumni_id 
                     ORDER BY a.created_at DESC LIMIT 5";
$recent_alumni = $conn->query($recent_alumni_sql);

// Get recent events
$recent_events_sql = "SELECT e.*, ec.category_name 
                     FROM EVENT e 
                     LEFT JOIN EVENT_CATEGORY ec ON e.category_id = ec.category_id 
                     ORDER BY e.event_date DESC LIMIT 5";
$recent_events = $conn->query($recent_events_sql);
?>
<?php include '../includes/header.php'; ?>

<div class="dashboard-header">
    <h1>Admin Dashboard</h1>
    <p>Welcome, Administrator! Manage the alumni portal from here.</p>
</div>

<div class="admin-stats">
    <div class="stat-card admin">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <h3><?php echo $stats['total_alumni']; ?></h3>
            <p>Total Alumni</p>
            <a href="alumni.php">View All</a>
        </div>
    </div>
    
    <div class="stat-card admin">
        <div class="stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <h3><?php echo $stats['pending_accounts']; ?></h3>
            <p>Pending Approvals</p>
            <a href="alumni.php?status=Pending">Review</a>
        </div>
    </div>
    
    <div class="stat-card admin">
        <div class="stat-icon">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="stat-content">
            <h3><?php echo $stats['upcoming_events']; ?></h3>
            <p>Upcoming Events</p>
            <a href="events.php">Manage</a>
        </div>
    </div>
    
    <div class="stat-card admin">
        <div class="stat-icon">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="stat-content">
            <h3><?php echo $stats['active_jobs']; ?></h3>
            <p>Active Jobs</p>
            <a href="jobs.php">View All</a>
        </div>
    </div>
    
    <div class="stat-card admin">
        <div class="stat-icon">
            <i class="fas fa-comments"></i>
        </div>
        <div class="stat-content">
            <h3><?php echo $stats['pending_feedback']; ?></h3>
            <p>Pending Feedback</p>
            <a href="feedback.php">Review</a>
        </div>
    </div>
    
    <div class="stat-card admin">
        <div class="stat-icon">
            <i class="fas fa-building"></i>
        </div>
        <div class="stat-content">
            <h3><?php echo $stats['total_companies']; ?></h3>
            <p>Companies</p>
            <a href="companies.php">Manage</a>
        </div>
    </div>
</div>

<div class="admin-quick-actions">
    <h2>Quick Actions</h2>
    <div class="action-grid">
        <a href="alumni.php?action=add" class="action-btn">
            <i class="fas fa-user-plus"></i>
            <span>Add Alumni</span>
        </a>
        <a href="events.php?action=add" class="action-btn">
            <i class="fas fa-calendar-plus"></i>
            <span>Create Event</span>
        </a>
        <a href="jobs.php?action=add" class="action-btn">
            <i class="fas fa-briefcase"></i>
            <span>Post Job</span>
        </a>
        <a href="announcements.php?action=add" class="action-btn">
            <i class="fas fa-bullhorn"></i>
            <span>Create Announcement</span>
        </a>
        <a href="companies.php?action=add" class="action-btn">
            <i class="fas fa-building"></i>
            <span>Add Company</span>
        </a>
        <a href="categories.php" class="action-btn">
            <i class="fas fa-tags"></i>
            <span>Manage Categories</span>
        </a>
    </div>
</div>

<div class="admin-recent">
    <div class="recent-section">
        <h3>Recent Alumni Registrations</h3>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Program</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($alumni = $recent_alumni->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($alumni['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($alumni['email']); ?></td>
                            <td><?php echo htmlspecialchars($alumni['program_name'] ?? 'N/A'); ?></td>
                            <td>
                                <span class="badge badge-<?php 
                                    echo $alumni['account_status'] === 'Approved' ? 'success' : 
                                         ($alumni['account_status'] === 'Pending' ? 'warning' : 'secondary'); 
                                ?>">
                                    <?php echo $alumni['account_status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="alumni.php?view=<?php echo $alumni['alumni_id']; ?>" class="btn btn-sm btn-secondary">View</a>
                                <?php if ($alumni['account_status'] === 'Pending'): ?>
                                    <a href="alumni.php?approve=<?php echo $alumni['alumni_id']; ?>" class="btn btn-sm btn-success">Approve</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="recent-section">
        <h3>Upcoming Events</h3>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($event = $recent_events->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['event_title']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($event['event_date'])); ?></td>
                            <td><?php echo htmlspecialchars($event['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($event['event_location']); ?></td>
                            <td>
                                <a href="events.php?view=<?php echo $event['event_id']; ?>" class="btn btn-sm btn-secondary">View</a>
                                <a href="events.php?edit=<?php echo $event['event_id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>