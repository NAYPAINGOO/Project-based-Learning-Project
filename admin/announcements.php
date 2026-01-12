<?php
require_once '../config/db.php';
requireAdmin();

$conn = getDBConnection();

// Handle announcement deletion
if (isset($_GET['delete'])) {
    $announcement_id = $_GET['delete'];
    $sql = "DELETE FROM ANNOUNCEMENT WHERE announcement_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $announcement_id);
    $stmt->execute();
    
    $_SESSION['message'] = "Announcement deleted successfully!";
    $_SESSION['message_type'] = 'success';
    header('Location: announcements.php');
    exit();
}

// Get announcements with category info
$sql = "SELECT a.*, ac.ann_category_name 
        FROM ANNOUNCEMENT a 
        LEFT JOIN ANNOUNCEMENT_CATEGORY ac ON a.ann_category_id = ac.ann_category_id 
        ORDER BY a.published_date DESC";
$result = $conn->query($sql);

// Get categories for filter
$categories_sql = "SELECT * FROM ANNOUNCEMENT_CATEGORY ORDER BY ann_category_name";
$categories_result = $conn->query($categories_sql);
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Manage Announcements</h1>
    <p>Create and publish announcements for alumni</p>
</div>

<div class="action-bar">
    <a href="?action=add" class="btn btn-success"><i class="fas fa-plus"></i> Create Announcement</a>
    <a href="categories.php" class="btn btn-secondary"><i class="fas fa-tags"></i> Manage Categories</a>
</div>

<div class="data-section">
    <div class="section-header">
        <h3>All Announcements</h3>
        <div class="filter-controls">
            <select class="form-control" id="categoryFilter">
                <option value="">All Categories</option>
                <?php while ($category = $categories_result->fetch_assoc()): ?>
                    <option value="<?php echo $category['ann_category_id']; ?>">
                        <?php echo htmlspecialchars($category['ann_category_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
    </div>
    
    <?php if ($result->num_rows > 0): ?>
        <div class="announcements-list admin">
            <?php while ($announcement = $result->fetch_assoc()): ?>
                <div class="announcement-card admin" data-category="<?php echo $announcement['ann_category_id']; ?>">
                    <div class="announcement-header">
                        <div>
                            <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                            <p class="announcement-category"><?php echo htmlspecialchars($announcement['ann_category_name']); ?></p>
                        </div>
                        <span class="announcement-date">
                            <?php echo date('M d, Y', strtotime($announcement['published_date'])); ?>
                        </span>
                    </div>
                    
                    <div class="announcement-body">
                        <p><?php echo nl2br(htmlspecialchars(substr($announcement['content'], 0, 150))); ?>...</p>
                    </div>
                    
                    <div class="announcement-footer">
                        <div class="action-buttons">
                            <a href="?view=<?php echo $announcement['announcement_id']; ?>" class="btn btn-sm btn-secondary">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="?edit=<?php echo $announcement['announcement_id']; ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="announcement-feedback.php?id=<?php echo $announcement['announcement_id']; ?>" 
                               class="btn btn-sm btn-info">
                                <i class="fas fa-comments"></i> Feedback
                            </a>
                            <a href="?delete=<?php echo $announcement['announcement_id']; ?>" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Delete this announcement?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-bullhorn"></i>
            <h3>No announcements found</h3>
            <p>Create your first announcement to get started.</p>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>