<?php
require_once '../config/db.php';
requireAdmin();

$conn = getDBConnection();

// Handle category actions
$action = $_GET['action'] ?? '';
$type = $_GET['type'] ?? 'event'; // event or announcement

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        $category_name = $_POST['category_name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        if ($type === 'event') {
            $sql = "INSERT INTO EVENT_CATEGORY (category_name) VALUES (?)";
        } else {
            $sql = "INSERT INTO ANNOUNCEMENT_CATEGORY (ann_category_name, ann_category_description) VALUES (?, ?)";
        }
        
        $stmt = $conn->prepare($sql);
        if ($type === 'event') {
            $stmt->bind_param("s", $category_name);
        } else {
            $stmt->bind_param("ss", $category_name, $description);
        }
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Category added successfully!";
            $_SESSION['message_type'] = 'success';
            header('Location: categories.php?type=' . $type);
            exit();
        }
    }
    
    if (isset($_POST['update_category'])) {
        $category_id = $_POST['category_id'] ?? '';
        $category_name = $_POST['category_name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        if ($type === 'event') {
            $sql = "UPDATE EVENT_CATEGORY SET category_name = ? WHERE category_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $category_name, $category_id);
        } else {
            $sql = "UPDATE ANNOUNCEMENT_CATEGORY SET ann_category_name = ?, ann_category_description = ? 
                    WHERE ann_category_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $category_name, $description, $category_id);
        }
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Category updated successfully!";
            $_SESSION['message_type'] = 'success';
            header('Location: categories.php?type=' . $type);
            exit();
        }
    }
}

// Handle category deletion
if (isset($_GET['delete'])) {
    $category_id = $_GET['delete'];
    
    if ($type === 'event') {
        // Check if category is being used
        $check_sql = "SELECT COUNT(*) as count FROM EVENT WHERE category_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $category_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $count = $check_result->fetch_assoc()['count'];
        
        if ($count > 0) {
            $_SESSION['message'] = "Cannot delete category. It is being used by $count event(s).";
            $_SESSION['message_type'] = 'danger';
        } else {
            $sql = "DELETE FROM EVENT_CATEGORY WHERE category_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $category_id);
            $stmt->execute();
            $_SESSION['message'] = "Category deleted successfully!";
            $_SESSION['message_type'] = 'success';
        }
    } else {
        // Check if category is being used
        $check_sql = "SELECT COUNT(*) as count FROM ANNOUNCEMENT WHERE ann_category_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $category_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $count = $check_result->fetch_assoc()['count'];
        
        if ($count > 0) {
            $_SESSION['message'] = "Cannot delete category. It is being used by $count announcement(s).";
            $_SESSION['message_type'] = 'danger';
        } else {
            $sql = "DELETE FROM ANNOUNCEMENT_CATEGORY WHERE ann_category_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $category_id);
            $stmt->execute();
            $_SESSION['message'] = "Category deleted successfully!";
            $_SESSION['message_type'] = 'success';
        }
    }
    
    header('Location: categories.php?type=' . $type);
    exit();
}

// Get categories based on type
if ($type === 'event') {
    $sql = "SELECT * FROM EVENT_CATEGORY ORDER BY category_name";
    $title = "Event Categories";
    $table_id = "category_id";
    $table_name = "category_name";
} else {
    $sql = "SELECT * FROM ANNOUNCEMENT_CATEGORY ORDER BY ann_category_name";
    $title = "Announcement Categories";
    $table_id = "ann_category_id";
    $table_name = "ann_category_name";
}

$result = $conn->query($sql);

// Get category for editing
$edit_category = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    if ($type === 'event') {
        $edit_sql = "SELECT * FROM EVENT_CATEGORY WHERE category_id = ?";
    } else {
        $edit_sql = "SELECT * FROM ANNOUNCEMENT_CATEGORY WHERE ann_category_id = ?";
    }
    $edit_stmt = $conn->prepare($edit_sql);
    $edit_stmt->bind_param("i", $edit_id);
    $edit_stmt->execute();
    $edit_result = $edit_stmt->get_result();
    $edit_category = $edit_result->fetch_assoc();
}
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Manage Categories</h1>
    <p>Organize events and announcements into categories</p>
</div>

<div class="category-tabs">
    <a href="?type=event" class="tab-btn <?php echo $type === 'event' ? 'active' : ''; ?>">
        <i class="fas fa-calendar-alt"></i> Event Categories
    </a>
    <a href="?type=announcement" class="tab-btn <?php echo $type === 'announcement' ? 'active' : ''; ?>">
        <i class="fas fa-bullhorn"></i> Announcement Categories
    </a>
</div>

<div class="category-container">
    <div class="category-form">
        <h3><?php echo $edit_category ? 'Edit' : 'Add New'; ?> Category</h3>
        <form method="POST" action="">
            <input type="hidden" name="type" value="<?php echo $type; ?>">
            <?php if ($edit_category): ?>
                <input type="hidden" name="category_id" value="<?php echo $edit_category[$table_id]; ?>">
                <input type="hidden" name="update_category" value="1">
            <?php else: ?>
                <input type="hidden" name="add_category" value="1">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="category_name">Category Name *</label>
                <input type="text" id="category_name" name="category_name" 
                       value="<?php echo $edit_category ? htmlspecialchars($edit_category[$table_name]) : ''; ?>" 
                       required>
            </div>
            
            <?php if ($type === 'announcement'): ?>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3"><?php 
                        echo $edit_category ? htmlspecialchars($edit_category['ann_category_description']) : ''; 
                    ?></textarea>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <?php echo $edit_category ? 'Update' : 'Add'; ?> Category
                </button>
                <?php if ($edit_category): ?>
                    <a href="categories.php?type=<?php echo $type; ?>" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <div class="category-list">
        <h3>Existing Categories (<?php echo $result->num_rows; ?>)</h3>
        
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <?php if ($type === 'announcement'): ?>
                                <th>Description</th>
                            <?php endif; ?>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($category = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $category[$table_id]; ?></td>
                                <td><?php echo htmlspecialchars($category[$table_name]); ?></td>
                                <?php if ($type === 'announcement'): ?>
                                    <td><?php echo htmlspecialchars($category['ann_category_description'] ?? ''); ?></td>
                                <?php endif; ?>
                                <td>
                                    <div class="action-buttons">
                                        <a href="?type=<?php echo $type; ?>&edit=<?php echo $category[$table_id]; ?>" 
                                           class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?type=<?php echo $type; ?>&delete=<?php echo $category[$table_id]; ?>" 
                                           class="btn btn-sm btn-danger" title="Delete"
                                           onclick="return confirm('Delete this category?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-tags"></i>
                <h4>No categories found</h4>
                <p>Add your first category to get started.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>