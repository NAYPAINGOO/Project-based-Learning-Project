<?php
require_once '../config/db.php';
requireAdmin();

$conn = getDBConnection();

// Handle event deletion
if (isset($_GET['delete'])) {
    $event_id = $_GET['delete'];
    $sql = "DELETE FROM EVENT WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    
    $_SESSION['message'] = "Event deleted successfully!";
    $_SESSION['message_type'] = 'success';
    header('Location: events.php');
    exit();
}

// Get events with registration counts
$sql = "SELECT e.*, ec.category_name, 
        (SELECT COUNT(*) FROM EVENT_REGISTRATION WHERE event_id = e.event_id) as registration_count
        FROM EVENT e 
        LEFT JOIN EVENT_CATEGORY ec ON e.category_id = ec.category_id 
        ORDER BY e.event_date DESC";
$result = $conn->query($sql);

// Get categories for filter
$categories_sql = "SELECT * FROM EVENT_CATEGORY ORDER BY category_name";
$categories_result = $conn->query($categories_sql);
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Manage Events</h1>
    <p>Create and manage alumni events</p>
</div>

<div class="action-bar">
    <a href="?action=add" class="btn btn-success"><i class="fas fa-plus"></i> Add New Event</a>
    <a href="event-categories.php" class="btn btn-secondary"><i class="fas fa-tags"></i> Manage Categories</a>
</div>

<div class="data-section">
    <div class="section-header">
        <h3>All Events</h3>
        <div class="filter-controls">
            <select class="form-control" id="categoryFilter">
                <option value="">All Categories</option>
                <?php while ($category = $categories_result->fetch_assoc()): ?>
                    <option value="<?php echo $category['category_id']; ?>">
                        <?php echo htmlspecialchars($category['category_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
    </div>
    
    <?php if ($result->num_rows > 0): ?>
        <div class="events-grid admin">
            <?php while ($event = $result->fetch_assoc()): ?>
                <div class="event-card admin" data-category="<?php echo $event['category_id']; ?>">
                    <div class="event-header">
                        <div>
                            <h3><?php echo htmlspecialchars($event['event_title']); ?></h3>
                            <p class="event-category"><?php echo htmlspecialchars($event['category_name']); ?></p>
                        </div>
                        <span class="event-date">
                            <?php echo date('M d, Y', strtotime($event['event_date'])); ?>
                        </span>
                    </div>
                    
                    <div class="event-body">
                        <p><?php echo htmlspecialchars(substr($event['event_description'], 0, 100)); ?>...</p>
                        
                        <div class="event-stats">
                            <div class="stat">
                                <i class="fas fa-users"></i>
                                <span><?php echo $event['registration_count']; ?> registered</span>
                            </div>
                            <div class="stat">
                                <i class="fas fa-clock"></i>
                                <span><?php echo date('g:i A', strtotime($event['event_time'])); ?></span>
                            </div>
                            <div class="stat">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo htmlspecialchars($event['event_location']); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="event-footer">
                        <div class="action-buttons">
                            <a href="?view=<?php echo $event['event_id']; ?>" class="btn btn-sm btn-secondary">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="?edit=<?php echo $event['event_id']; ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="event-registrations.php?id=<?php echo $event['event_id']; ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-list"></i> Registrations
                            </a>
                            <a href="?delete=<?php echo $event['event_id']; ?>" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Delete this event?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <h3>No events found</h3>
            <p>Create your first event to get started.</p>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>