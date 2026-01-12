<?php
require_once '../config/db.php';
requireLogin();

$conn = getDBConnection();
$user_id = $_SESSION['user_id'];

// Get announcement categories
$categories_sql = "SELECT * FROM ANNOUNCEMENT_CATEGORY ORDER BY ann_category_name";
$categories_result = $conn->query($categories_sql);

// Get announcements
$where_conditions = [];
$params = [];
$types = "";

if (isset($_GET['category']) && $_GET['category']) {
    $where_conditions[] = "a.ann_category_id = ?";
    $params[] = $_GET['category'];
    $types .= "i";
}

$where_sql = $where_conditions ? "WHERE " . implode(" AND ", $where_conditions) : "";
$announcements_sql = "SELECT a.*, ac.ann_category_name 
                     FROM ANNOUNCEMENT a 
                     LEFT JOIN ANNOUNCEMENT_CATEGORY ac ON a.ann_category_id = ac.ann_category_id 
                     $where_sql 
                     ORDER BY a.published_date DESC, a.announcement_id DESC";

$announcements_stmt = $conn->prepare($announcements_sql);
if ($params) {
    $announcements_stmt->bind_param($types, ...$params);
}
$announcements_stmt->execute();
$announcements_result = $announcements_stmt->get_result();
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Announcements</h1>
    <p>Latest updates and news from AIU</p>
</div>

<div class="announcements-container">
    <div class="announcements-sidebar">
        <div class="filter-card">
            <h3>Categories</h3>
            <ul class="category-list">
                <li>
                    <a href="announcements.php" class="<?php echo !isset($_GET['category']) ? 'active' : ''; ?>">
                        All Categories
                    </a>
                </li>
                <?php while ($category = $categories_result->fetch_assoc()): ?>
                    <li>
                        <a href="?category=<?php echo $category['ann_category_id']; ?>"
                           class="<?php echo (isset($_GET['category']) && $_GET['category'] == $category['ann_category_id']) ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($category['ann_category_name']); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        
        <div class="recent-feedback">
            <h3>Recent Feedback</h3>
            <?php
            $feedback_sql = "SELECT f.*, a.title 
                            FROM FEEDBACK f 
                            JOIN ANNOUNCEMENT a ON f.announcement_id = a.announcement_id 
                            WHERE f.alumni_id = ? 
                            ORDER BY f.feedback_date DESC 
                            LIMIT 3";
            $feedback_stmt = $conn->prepare($feedback_sql);
            $feedback_stmt->bind_param("i", $user_id);
            $feedback_stmt->execute();
            $feedback_result = $feedback_stmt->get_result();
            
            if ($feedback_result->num_rows > 0): ?>
                <?php while ($feedback = $feedback_result->fetch_assoc()): ?>
                    <div class="feedback-item">
                        <p class="feedback-title"><?php echo htmlspecialchars(substr($feedback['title'], 0, 30)); ?>...</p>
                        <p class="feedback-message"><?php echo htmlspecialchars(substr($feedback['feedback_message'], 0, 50)); ?>...</p>
                        <span class="feedback-status badge badge-<?php echo $feedback['status'] === 'Approved' ? 'success' : 'warning'; ?>">
                            <?php echo $feedback['status']; ?>
                        </span>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No feedback submitted yet.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="announcements-content">
        <?php if ($announcements_result->num_rows > 0): ?>
            <div class="announcements-list">
                <?php while ($announcement = $announcements_result->fetch_assoc()): ?>
                    <div class="announcement-card">
                        <div class="announcement-header">
                            <span class="announcement-category">
                                <?php echo htmlspecialchars($announcement['ann_category_name']); ?>
                            </span>
                            <span class="announcement-date">
                                <i class="fas fa-calendar"></i>
                                <?php echo date('M d, Y', strtotime($announcement['published_date'])); ?>
                            </span>
                        </div>
                        
                        <div class="announcement-body">
                            <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars(substr($announcement['content'], 0, 200))); ?>...</p>
                        </div>
                        
                        <div class="announcement-footer">
                            <a href="announcement-details.php?id=<?php echo $announcement['announcement_id']; ?>" class="btn btn-primary">
                                Read More
                            </a>
                            <button class="btn btn-secondary btn-feedback" 
                                    data-announcement-id="<?php echo $announcement['announcement_id']; ?>"
                                    data-announcement-title="<?php echo htmlspecialchars($announcement['title']); ?>">
                                <i class="fas fa-comment"></i> Give Feedback
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-bullhorn"></i>
                <h3>No announcements found</h3>
                <p>Check back later for new updates.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Feedback Modal -->
<div id="feedbackModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Submit Feedback</h3>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="feedbackForm">
                <input type="hidden" id="feedbackAnnouncementId" name="announcement_id">
                <div class="form-group">
                    <label for="feedbackMessage">Your Feedback *</label>
                    <textarea id="feedbackMessage" name="feedback_message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Feedback</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>