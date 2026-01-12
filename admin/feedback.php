<?php
require_once '../config/db.php';
requireAdmin();

$conn = getDBConnection();

// Handle feedback actions
if (isset($_GET['approve'])) {
    $feedback_id = $_GET['approve'];
    $sql = "UPDATE FEEDBACK SET status = 'Approved' WHERE feedback_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $feedback_id);
    $stmt->execute();
    
    $_SESSION['message'] = "Feedback approved!";
    $_SESSION['message_type'] = 'success';
    header('Location: feedback.php');
    exit();
}

if (isset($_GET['delete'])) {
    $feedback_id = $_GET['delete'];
    $sql = "DELETE FROM FEEDBACK WHERE feedback_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $feedback_id);
    $stmt->execute();
    
    $_SESSION['message'] = "Feedback deleted!";
    $_SESSION['message_type'] = 'success';
    header('Location: feedback.php');
    exit();
}

// Get filter parameters
$status_filter = $_GET['status'] ?? 'Pending';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';

// Build query
$where_conditions = ["f.status = ?"];
$params = [$status_filter];
$types = "s";

if ($date_from) {
    $where_conditions[] = "DATE(f.feedback_date) >= ?";
    $params[] = $date_from;
    $types .= "s";
}

if ($date_to) {
    $where_conditions[] = "DATE(f.feedback_date) <= ?";
    $params[] = $date_to;
    $types .= "s";
}

$where_sql = "WHERE " . implode(" AND ", $where_conditions);

// Get feedback with alumni and announcement info
$sql = "SELECT f.*, a.full_name, a.email, ann.title as announcement_title, 
               ac.ann_category_name 
        FROM FEEDBACK f 
        LEFT JOIN ALUMNI a ON f.alumni_id = a.alumni_id 
        LEFT JOIN ANNOUNCEMENT ann ON f.announcement_id = ann.announcement_id 
        LEFT JOIN ANNOUNCEMENT_CATEGORY ac ON ann.ann_category_id = ac.ann_category_id 
        $where_sql 
        ORDER BY f.feedback_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Manage Feedback</h1>
    <p>Review and moderate alumni feedback</p>
</div>

<div class="filter-card">
    <h3>Filters</h3>
    <form method="GET" action="">
        <div class="form-row">
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="Pending" <?php echo $status_filter === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Approved" <?php echo $status_filter === 'Approved' ? 'selected' : ''; ?>>Approved</option>
                    <option value="">All Statuses</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Date From</label>
                <input type="date" name="date_from" value="<?php echo $date_from; ?>">
            </div>
            
            <div class="form-group">
                <label>Date To</label>
                <input type="date" name="date_to" value="<?php echo $date_to; ?>">
            </div>
        </div>
        
        <div class="form-row">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
            <a href="feedback.php" class="btn btn-secondary">Clear Filters</a>
        </div>
    </form>
</div>

<div class="data-section">
    <div class="section-header">
        <h3>Feedback (<?php echo $result->num_rows; ?> found)</h3>
        <span class="badge badge-<?php echo $status_filter === 'Pending' ? 'warning' : 'success'; ?>">
            <?php echo $status_filter ?: 'All'; ?>
        </span>
    </div>
    
    <?php if ($result->num_rows > 0): ?>
        <div class="feedback-list admin">
            <?php while ($feedback = $result->fetch_assoc()): ?>
                <div class="feedback-item admin">
                    <div class="feedback-header">
                        <div class="feedback-sender">
                            <h4><?php echo htmlspecialchars($feedback['full_name']); ?></h4>
                            <p><?php echo htmlspecialchars($feedback['email']); ?></p>
                        </div>
                        <div class="feedback-meta">
                            <span class="feedback-date">
                                <?php echo date('M d, Y H:i', strtotime($feedback['feedback_date'])); ?>
                            </span>
                            <span class="badge badge-<?php echo $feedback['status'] === 'Approved' ? 'success' : 'warning'; ?>">
                                <?php echo $feedback['status']; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="feedback-body">
                        <?php if ($feedback['announcement_title']): ?>
                            <div class="feedback-context">
                                <strong>Regarding:</strong> 
                                <a href="../user/announcement-details.php?id=<?php echo $feedback['announcement_id']; ?>">
                                    <?php echo htmlspecialchars($feedback['announcement_title']); ?>
                                </a>
                                <small>(<?php echo htmlspecialchars($feedback['ann_category_name']); ?>)</small>
                            </div>
                        <?php else: ?>
                            <div class="feedback-context">
                                <strong>General Feedback</strong>
                            </div>
                        <?php endif; ?>
                        
                        <div class="feedback-message">
                            <p><?php echo nl2br(htmlspecialchars($feedback['feedback_message'])); ?></p>
                        </div>
                    </div>
                    
                    <div class="feedback-footer">
                        <div class="action-buttons">
                            <?php if ($feedback['status'] === 'Pending'): ?>
                                <a href="?approve=<?php echo $feedback['feedback_id']; ?>" class="btn btn-sm btn-success">
                                    <i class="fas fa-check"></i> Approve
                                </a>
                            <?php endif; ?>
                            <a href="?delete=<?php echo $feedback['feedback_id']; ?>" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Delete this feedback?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                            <button class="btn btn-sm btn-secondary btn-reply" 
                                    data-email="<?php echo htmlspecialchars($feedback['email']); ?>">
                                <i class="fas fa-reply"></i> Reply
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-comments"></i>
            <h3>No feedback found</h3>
            <p>No feedback matches your current filters.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Reply Modal -->
<div id="replyModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Reply to Feedback</h3>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="replyForm">
                <div class="form-group">
                    <label>To</label>
                    <input type="email" id="replyEmail" readonly>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" id="replySubject" required>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea id="replyMessage" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Reply</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>