<?php
require_once '../config/db.php';
requireAdmin();

$conn = getDBConnection();

// Handle company actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_company'])) {
        $company_name = $_POST['company_name'] ?? '';
        $company_email = $_POST['company_email'] ?? '';
        $company_phone = $_POST['company_phone'] ?? '';
        $company_address = $_POST['company_address'] ?? '';
        $industry = $_POST['industry'] ?? '';
        
        $sql = "INSERT INTO COMPANY (company_name, company_email, company_phone, company_address, industry) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $company_name, $company_email, $company_phone, $company_address, $industry);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Company added successfully!";
            $_SESSION['message_type'] = 'success';
            header('Location: companies.php');
            exit();
        }
    }
    
    if (isset($_POST['update_company'])) {
        $company_id = $_POST['company_id'] ?? '';
        $company_name = $_POST['company_name'] ?? '';
        $company_email = $_POST['company_email'] ?? '';
        $company_phone = $_POST['company_phone'] ?? '';
        $company_address = $_POST['company_address'] ?? '';
        $industry = $_POST['industry'] ?? '';
        
        $sql = "UPDATE COMPANY SET 
                company_name = ?, 
                company_email = ?, 
                company_phone = ?, 
                company_address = ?, 
                industry = ? 
                WHERE company_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $company_name, $company_email, $company_phone, $company_address, $industry, $company_id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Company updated successfully!";
            $_SESSION['message_type'] = 'success';
            header('Location: companies.php');
            exit();
        }
    }
}

// Handle company deletion
if (isset($_GET['delete'])) {
    $company_id = $_GET['delete'];
    
    // Check if company has job postings
    $check_sql = "SELECT COUNT(*) as count FROM JOB WHERE company_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $company_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $count = $check_result->fetch_assoc()['count'];
    
    if ($count > 0) {
        $_SESSION['message'] = "Cannot delete company. It has $count job posting(s).";
        $_SESSION['message_type'] = 'danger';
    } else {
        $sql = "DELETE FROM COMPANY WHERE company_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $company_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Company deleted successfully!";
            $_SESSION['message_type'] = 'success';
        }
    }
    
    header('Location: companies.php');
    exit();
}

// Get all companies
$sql = "SELECT c.*, 
        (SELECT COUNT(*) FROM JOB WHERE company_id = c.company_id) as job_count
        FROM COMPANY c 
        ORDER BY company_name";
$result = $conn->query($sql);

// Get company for editing
$edit_company = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_sql = "SELECT * FROM COMPANY WHERE company_id = ?";
    $edit_stmt = $conn->prepare($edit_sql);
    $edit_stmt->bind_param("i", $edit_id);
    $edit_stmt->execute();
    $edit_result = $edit_stmt->get_result();
    $edit_company = $edit_result->fetch_assoc();
}

// Common industries for dropdown
$industries = [
    'Technology', 'Finance', 'Healthcare', 'Education', 'Manufacturing',
    'Retail', 'Hospitality', 'Construction', 'Transportation', 'Energy',
    'Media', 'Telecommunications', 'Consulting', 'Real Estate'
];
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Manage Companies</h1>
    <p>Add and manage partner companies for job postings</p>
</div>

<div class="companies-container">
    <div class="company-form">
        <h3><?php echo $edit_company ? 'Edit' : 'Add New'; ?> Company</h3>
        <form method="POST" action="">
            <?php if ($edit_company): ?>
                <input type="hidden" name="company_id" value="<?php echo $edit_company['company_id']; ?>">
                <input type="hidden" name="update_company" value="1">
            <?php else: ?>
                <input type="hidden" name="add_company" value="1">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="company_name">Company Name *</label>
                <input type="text" id="company_name" name="company_name" 
                       value="<?php echo $edit_company ? htmlspecialchars($edit_company['company_name']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="company_email">Email Address</label>
                    <input type="email" id="company_email" name="company_email" 
                           value="<?php echo $edit_company ? htmlspecialchars($edit_company['company_email']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="company_phone">Phone Number</label>
                    <input type="tel" id="company_phone" name="company_phone" 
                           value="<?php echo $edit_company ? htmlspecialchars($edit_company['company_phone']) : ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="industry">Industry</label>
                <select id="industry" name="industry" class="form-control">
                    <option value="">Select Industry</option>
                    <?php foreach ($industries as $industry): ?>
                        <option value="<?php echo $industry; ?>" 
                            <?php echo ($edit_company && $edit_company['industry'] === $industry) ? 'selected' : ''; ?>>
                            <?php echo $industry; ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="Other">Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="company_address">Address</label>
                <textarea id="company_address" name="company_address" rows="3"><?php 
                    echo $edit_company ? htmlspecialchars($edit_company['company_address']) : ''; 
                ?></textarea>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <?php echo $edit_company ? 'Update' : 'Add'; ?> Company
                </button>
                <?php if ($edit_company): ?>
                    <a href="companies.php" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <div class="company-list">
        <h3>All Companies (<?php echo $result->num_rows; ?>)</h3>
        
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Industry</th>
                            <th>Contact</th>
                            <th>Jobs Posted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($company = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($company['company_name']); ?></strong>
                                    <?php if ($company['company_email']): ?>
                                        <br><small><?php echo htmlspecialchars($company['company_email']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($company['industry']): ?>
                                        <span class="badge badge-info"><?php echo $company['industry']; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($company['company_phone']): ?>
                                        <small><?php echo htmlspecialchars($company['company_phone']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-primary"><?php echo $company['job_count']; ?> jobs</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="jobs.php?company=<?php echo $company['company_id']; ?>" 
                                           class="btn btn-sm btn-info" title="View Jobs">
                                            <i class="fas fa-briefcase"></i>
                                        </a>
                                        <a href="?edit=<?php echo $company['company_id']; ?>" 
                                           class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?delete=<?php echo $company['company_id']; ?>" 
                                           class="btn btn-sm btn-danger" title="Delete"
                                           onclick="return confirm('Delete this company?')">
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
                <i class="fas fa-building"></i>
                <h4>No companies found</h4>
                <p>Add your first partner company to get started.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>