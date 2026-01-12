<?php
require_once '../config/db.php';
requireAdmin();

$conn = getDBConnection();

// Handle actions
if (isset($_GET['approve'])) {
    $alumni_id = $_GET['approve'];
    $sql = "UPDATE ACCOUNT SET account_status = 'Approved' WHERE alumni_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $alumni_id);
    $stmt->execute();
    
    $_SESSION['message'] = "Alumni account approved successfully!";
    $_SESSION['message_type'] = 'success';
    header('Location: alumni.php');
    exit();
}

if (isset($_GET['reject'])) {
    $alumni_id = $_GET['reject'];
    $sql = "UPDATE ACCOUNT SET account_status = 'Inactive' WHERE alumni_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $alumni_id);
    $stmt->execute();
    
    $_SESSION['message'] = "Alumni account rejected.";
    $_SESSION['message_type'] = 'warning';
    header('Location: alumni.php');
    exit();
}

// Get filter parameters
$status_filter = $_GET['status'] ?? '';
$program_filter = $_GET['program'] ?? '';
$search = $_GET['search'] ?? '';

// Build query
$where_conditions = [];
$params = [];
$types = "";

if ($status_filter) {
    $where_conditions[] = "ac.account_status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

if ($program_filter) {
    $where_conditions[] = "a.program_id = ?";
    $params[] = $program_filter;
    $types .= "i";
}

if ($search) {
    $where_conditions[] = "(a.full_name LIKE ? OR a.email LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= "ss";
}

$where_sql = $where_conditions ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Get alumni data
$sql = "SELECT a.*, p.program_name, ac.account_status, ac.username 
        FROM ALUMNI a 
        LEFT JOIN PROGRAM p ON a.program_id = p.program_id 
        LEFT JOIN ACCOUNT ac ON a.alumni_id = ac.alumni_id 
        $where_sql 
        ORDER BY a.created_at DESC";
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Get programs for filter
$programs_sql = "SELECT * FROM PROGRAM ORDER BY program_name";
$programs_result = $conn->query($programs_sql);
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Manage Alumni</h1>
    <p>View and manage alumni accounts</p>
</div>

<div class="filter-card">
    <h3>Filters</h3>
    <form method="GET" action="">
        <div class="form-row">
            <div class="form-group">
                <label>Account Status</label>
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="Pending" <?php echo $status_filter === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Approved" <?php echo $status_filter === 'Approved' ? 'selected' : ''; ?>>Approved</option>
                    <option value="Inactive" <?php echo $status_filter === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Program</label>
                <select name="program" class="form-control">
                    <option value="">All Programs</option>
                    <?php while ($program = $programs_result->fetch_assoc()): ?>
                        <option value="<?php echo $program['program_id']; ?>" 
                            <?php echo $program_filter == $program['program_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($program['program_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Search</label>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                       placeholder="Search by name or email...">
            </div>
        </div>
        
        <div class="form-row">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
            <a href="alumni.php" class="btn btn-secondary">Clear Filters</a>
            <a href="?action=add" class="btn btn-success"><i class="fas fa-plus"></i> Add Alumni</a>
        </div>
    </form>
</div>

<div class="data-section">
    <div class="section-header">
        <h3>Alumni List (<?php echo $result->num_rows; ?> found)</h3>
        <a href="export-alumni.php" class="btn btn-outline"><i class="fas fa-download"></i> Export</a>
    </div>
    
    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Program</th>
                        <th>Graduation Year</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($alumni = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $alumni['alumni_id']; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($alumni['full_name']); ?></strong><br>
                                <small>Username: <?php echo htmlspecialchars($alumni['username']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($alumni['email']); ?></td>
                            <td><?php echo htmlspecialchars($alumni['program_name'] ?? 'N/A'); ?></td>
                            <td><?php echo $alumni['graduation_year']; ?></td>
                            <td>
                                <span class="badge badge-<?php 
                                    echo $alumni['account_status'] === 'Approved' ? 'success' : 
                                         ($alumni['account_status'] === 'Pending' ? 'warning' : 'secondary'); 
                                ?>">
                                    <?php echo $alumni['account_status']; ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($alumni['created_at'])); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="?view=<?php echo $alumni['alumni_id']; ?>" class="btn btn-sm btn-secondary" 
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="?edit=<?php echo $alumni['alumni_id']; ?>" class="btn btn-sm btn-primary"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($alumni['account_status'] === 'Pending'): ?>
                                        <a href="?approve=<?php echo $alumni['alumni_id']; ?>" class="btn btn-sm btn-success"
                                           title="Approve">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="?reject=<?php echo $alumni['alumni_id']; ?>" class="btn btn-sm btn-warning"
                                           title="Reject">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="?delete=<?php echo $alumni['alumni_id']; ?>" class="btn btn-sm btn-danger"
                                       title="Delete" onclick="return confirm('Are you sure?')">
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
            <i class="fas fa-users"></i>
            <h3>No alumni found</h3>
            <p>Try adjusting your filters or add new alumni.</p>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>