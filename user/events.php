<?php
require_once '../config/db.php';
requireLogin();

$conn = getDBConnection();
$user_id = $_SESSION['user_id'];

// Get upcoming events
$events_sql = "SELECT e.*, ec.category_name, 
               (SELECT COUNT(*) FROM EVENT_REGISTRATION WHERE event_id = e.event_id) as registered_count,
               (SELECT attendance_status FROM EVENT_REGISTRATION WHERE event_id = e.event_id AND alumni_id = ?) as user_status
               FROM EVENT e 
               LEFT JOIN EVENT_CATEGORY ec ON e.category_id = ec.category_id 
               WHERE e.event_date >= CURDATE() 
               ORDER BY e.event_date, e.event_time";
$events_stmt = $conn->prepare($events_sql);
$events_stmt->bind_param("i", $user_id);
$events_stmt->execute();
$events_result = $events_stmt->get_result();

// Get past events user attended
$past_events_sql = "SELECT e.*, ec.category_name, er.attendance_status 
                    FROM EVENT e 
                    LEFT JOIN EVENT_CATEGORY ec ON e.category_id = ec.category_id 
                    INNER JOIN EVENT_REGISTRATION er ON e.event_id = er.event_id 
                    WHERE er.alumni_id = ? AND e.event_date < CURDATE() 
                    ORDER BY e.event_date DESC 
                    LIMIT 10";
$past_events_stmt = $conn->prepare($past_events_sql);
$past_events_stmt->bind_param("i", $user_id);
$past_events_stmt->execute();
$past_events_result = $past_events_stmt->get_result();

$message = '';
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'register') {
        $message = 'Successfully registered for event!';
    } elseif ($_GET['action'] === 'cancel') {
        $message = 'Registration cancelled.';
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Events</h1>
    <p>Browse and register for alumni events</p>
</div>

<?php if ($message): ?>
    <div class="alert alert-success"><?php echo $message; ?></div>
<?php endif; ?>

<div class="events-tabs">
    <button class="tab-btn active" data-tab="upcoming">Upcoming Events</button>
    <button class="tab-btn" data-tab="past">Past Events</button>
    <button class="tab-btn" data-tab="registered">My Registrations</button>
</div>

<div class="tab-content active" id="upcoming">
    <div class="events-grid">
        <?php if ($events_result->num_rows > 0): ?>
            <?php while ($event = $events_result->fetch_assoc()): ?>
                <div class="event-card">
                    <div class="event-header">
                        <span class="event-category"><?php echo htmlspecialchars($event['category_name']); ?></span>
                        <span class="event-date">
                            <i class="fas fa-calendar"></i>
                            <?php echo date('M d, Y', strtotime($event['event_date'])); ?>
                        </span>
                    </div>
                    
                    <div class="event-body">
                        <h3><?php echo htmlspecialchars($event['event_title']); ?></h3>
                        <p><?php echo htmlspecialchars(substr($event['event_description'], 0, 100)); ?>...</p>
                        
                        <div class="event-details">
                            <div class="detail">
                                <i class="fas fa-clock"></i>
                                <?php echo date('g:i A', strtotime($event['event_time'])); ?>
                            </div>
                            <div class="detail">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo htmlspecialchars($event['event_location']); ?>
                            </div>
                            <div class="detail">
                                <i class="fas fa-users"></i>
                                <?php echo $event['registered_count']; ?> registered
                            </div>
                        </div>
                    </div>
                    
                    <div class="event-footer">
                        <?php if ($event['user_status']): ?>
                            <span class="badge badge-<?php echo $event['user_status'] === 'Registered' ? 'info' : ($event['user_status'] === 'Attended' ? 'success' : 'warning'); ?>">
                                <?php echo $event['user_status']; ?>
                            </span>
                            <?php if ($event['user_status'] === 'Registered'): ?>
                                <a href="?cancel=<?php echo $event['event_id']; ?>" class="btn btn-warning btn-sm">Cancel</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="?register=<?php echo $event['event_id']; ?>" class="btn btn-primary">Register</a>
                        <?php endif; ?>
                        <a href="event-details.php?id=<?php echo $event['event_id']; ?>" class="btn btn-secondary">Details</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h3>No upcoming events</h3>
                <p>Check back later for new events.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="tab-content" id="past">
    <div class="events-list">
        <?php if ($past_events_result->num_rows > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($event = $past_events_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['event_title']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($event['event_date'])); ?></td>
                            <td><?php echo htmlspecialchars($event['category_name']); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $event['attendance_status'] === 'Attended' ? 'success' : 'warning'; ?>">
                                    <?php echo $event['attendance_status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="event-details.php?id=<?php echo $event['event_id']; ?>" class="btn btn-sm btn-secondary">View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-history"></i>
                <h3>No past events</h3>
                <p>You haven't attended any events yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="tab-content" id="registered">
    <div class="events-list">
        <!-- Registered events will be loaded here via JavaScript -->
        <div class="empty-state">
            <i class="fas fa-clipboard-list"></i>
            <h3>Loading your registrations...</h3>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>