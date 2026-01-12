<?php
require_once '../config/db.php';
requireLogin();

$conn = getDBConnection();
$user_id = $_SESSION['user_id'];

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_feedback'])) {
    $announcement_id = $_POST['announcement_id'] ?? null;
    $feedback_message = $_POST['feedback_message'] ?? '';
    
    $sql = "INSERT INTO FEEDBACK (announcement_id, alumni_id, feedback_message) 
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $announcement_id, $user_id, $feedback_message);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Feedback submitted successfully! It will be reviewed by administrators.";
        $_SESSION['message_type'] = 'success';
        header('Location: feedback.php');
        exit();
    }
}

// Get user's feedback submissions
$feedback_sql = "SELECT f.*, a.title, ac.ann_category_name 
                FROM FEEDBACK f 
                LEFT JOIN ANNOUNCEMENT a ON f.announcement_id = a.announcement_id 
                LEFT JOIN ANNOUNCEMENT_CATEGORY ac ON a.ann_category_id = ac.ann_category_id 
                WHERE f.alumni_id = ? 
                ORDER BY f.feedback_date DESC";
$feedback_stmt = $conn->prepare($feedback_sql);
$feedback_stmt->bind_param("i", $user_id);
$feedback_stmt->execute();
$feedback_result = $feedback_stmt->get_result();

// Get announcements for general feedback
$announcements_sql = "SELECT announcement_id, title FROM ANNOUNCEMENT 
                     ORDER BY published_date DESC LIMIT 10";
$announcements_result = $conn->query($announcements_sql);
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Feedback</h1>
    <p>Share your thoughts and suggestions with AIU</p>
</div>

<div class="feedback-container">
    <div class="feedback-form-card">
        <h3>Submit General Feedback</h3>
        <form method="POST" action="">
            <div class="form-group">
                <label for="announcement_id">Related Announcement (Optional)</label>
                <select id="announcement_id" name="announcement_id">
                    <option value="">General Feedback</option>
                    <?php while ($announcement = $announcements_result->fetch_assoc()): ?>
                        <option value="<?php echo $announcement['announcement_id']; ?>">
                            <?php echo htmlspecialchars($announcement['title']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="feedback_message">Your Feedback *</label>
                <textarea id="feedback_message" name="feedback_message" rows="5" required></textarea>
            </div>
            
            <button type="submit" name="submit_feedback" class="btn btn-primary">Submit Feedback</button>
        </form>
    </div>
    
    <div class="feedback-history">
        <h3>Your Feedback History</h3>
        
        <?php if ($feedback_result->num_rows > 0): ?>
            <div class="feedback-list">
                <?php while ($feedback = $feedback_result->fetch_assoc()): ?>
                    <div class="feedback-item">
                        <div class="feedback-header">
                            <?php if ($feedback['announcement_id']): ?>
                                <span class="feedback-category"><?php echo htmlspecialchars($feedback['ann_category_name']); ?></span>
                                <h4><?php echo htmlspecialchars($feedback['title']); ?></h4>
                            <?php else: ?>
                                <span class="feedback-category">General</span>
                                <h4>General Feedback</h4>
                            <?php endif; ?>
                            <span class="feedback-date">
                                <?php echo date('M d, Y', strtotime($feedback['feedback_date'])); ?>
                            </span>
                        </div>
                        
                        <div class="feedback-body">
                            <p><?php echo nl2br(htmlspecialchars($feedback['feedback_message'])); ?></p>
                        </div>
                        
                        <div class="feedback-footer">
                            <span class="badge badge-<?php echo $feedback['status'] === 'Approved' ? 'success' : 'warning'; ?>">
                                <?php echo $feedback['status']; ?>
                            </span>
                            <?php if ($feedback['status'] === 'Pending'): ?>
                                <small>Awaiting admin review</small>
                            <?php elseif ($feedback['status'] === 'Approved'): ?>
                                <small>Reviewed by admin</small>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-comments"></i>
                <h4>No feedback submitted yet</h4>
                <p>Your feedback helps us improve the alumni portal.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>