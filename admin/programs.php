<?php
require_once '../config/db.php';
requireAdmin();

$conn = getDBConnection();

// Handle program actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_program'])) {
        $program_name = $_POST['program_name'] ?? '';
        $faculty = $_POST['faculty'] ?? '';
        $degree_level = $_POST['degree_level'] ?? '';
        $year_established = $_POST['year_established'] ?? '';
        
        $sql = "INSERT INTO PROGRAM (program_name, faculty, degree_level, year_established) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $program_name, $faculty, $degree_level, $year_established);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Program added successfully!";
            $_SESSION['message_type'] = 'success';
            header('Location: programs.php');
            exit();
        }
    }
    
    if (isset($_POST['update_program'])) {
        $program_id = $_POST['program_id'] ?? '';
        $program_name = $_POST['program_name'] ?? '';
        $faculty = $_POST['faculty'] ?? '';
        $degree_level = $_POST['degree_level'] ?? '';
        $year_established = $_POST['year_established'] ?? '';
        
        $sql = "UPDATE PROGRAM SET program_name = ?, faculty = ?, degree_level = ?, year_established = ? 
                WHERE program_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $program_name, $faculty, $degree_level, $year_established, $program_id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Program updated successfully!";
            $_SESSION['message_type'] = 'success';
            header('Location: programs.php');
            exit();
        }
    }
}

// Handle program deletion
if (isset($_GET['delete'])) {
    $program_id = $_GET['delete'];
    
    // Check if program has alumni
    $check_sql = "SELECT COUNT(*) as count FROM ALUMNI WHERE program_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $program_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $count = $check_result->fetch_assoc()['count'];
    
    if ($count > 0) {
        $_SESSION['message'] = "Cannot delete program. It has $count alumni registered.";
        $_SESSION['message_type'] = 'danger';
    } else {
        $sql = "DELETE FROM PROGRAM WHERE program_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $program_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Program deleted successfully!";
            $_SESSION['message_type'] = 'success';
        }
    }
    
    header('Location: programs.php');
    exit();
}

// Get all programs
$sql = "SELECT p.*, 
        (SELECT COUNT(*) FROM ALUMNI WHERE program_id = p.program_id) as alumni_count
        FROM PROGRAM p 
        ORDER BY program_name";
$result = $conn->query($sql);

// Get program for editing
$edit_program = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_sql = "SELECT * FROM PROGRAM WHERE program_id = ?";
    $edit_stmt = $conn->prepare($edit_sql);
    $edit_stmt->bind_param("i", $edit_id);
    $edit_stmt->execute();
    $edit_result = $edit_stmt->get_result();
    $edit_program = $edit_result->fetch_assoc();
}

// Degree levels for dropdown
$degree_levels = ['Diploma', 'Bachelor', 'Master', 'PhD'];
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Manage Academic Programs</h1>
    <p>Add and manage academic programs offered by AIU</p>
</div>

<div class="programs-container">
    <div class="program-form">
        <h3><?php echo $edit_program ? 'Edit' : 'Add New'; ?> Program</h3>
        <form method="POST" action="">
            <?php if ($edit_program): ?>
                <input type="hidden" name="program_id" value="<?php echo $edit_program['program_id']; ?>">
                <input type="hidden" name="update_program" value="1">
            <?php else: ?>
                <input type="hidden" name="add_program" value="1">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="program_name">Program Name *</label>
                <input type="text" id="program_name" name="program_name" 
                       value="<?php echo $edit_program ? htmlspecialchars($edit_program['program_name']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="faculty">Faculty</label>
                <input type="text" id="faculty" name="faculty" 
                       value="<?php echo $edit_program ? htmlspecialchars($edit_program['faculty']) : ''; ?>">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="degree_level">Degree Level</label>
                    <select id="degree_level" name="degree_level" class="form-control">
                        <option value="">Select Level</option>
                        <?php foreach ($degree_levels as $level): ?>
                            <option value="<?php echo $level; ?>" 
                                <?php echo ($edit_program && $edit_program['degree_level'] === $level) ? 'selected' : ''; ?>>
                                <?php echo $level; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="year_established">Year Established</label>
                    <input type="number" id="year_established" name="year_established" 
                           min="1900" max="<?php echo date('Y'); ?>"
                           value="<?php echo $edit_program ? $edit_program['year_established'] : ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <?php echo $edit_program ? 'Update' : 'Add'; ?> Program
                </button>
                <?php if ($edit_program): ?>
                    <a href="programs.php" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <div class="program-list">
        <h3>All Programs (<?php echo $result->num_rows; ?>)</h3>
        
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Program Name</th>
                            <th>Faculty</th>
                            <th>Degree Level</th>
                            <th>Established</th>
                            <th>Alumni Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($program = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($program['program_name']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($program['faculty']); ?></td>
                                <td>
                                    <?php if ($program['degree_level']): ?>
                                        <span class="badge badge-info"><?php echo $program['degree_level']; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $program['year_established']; ?></td>
                                <td>
                                    <span class="badge badge-primary"><?php echo $program['alumni_count']; ?> alumni</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="alumni.php?program=<?php echo $program['program_id']; ?>" 
                                           class="btn btn-sm btn-info" title="View Alumni">
                                            <i class="fas fa-users"></i>
                                        </a>
                                        <a href="?edit=<?php echo $program['program_id']; ?>" 
                                           class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?delete=<?php echo $program['program_id']; ?>" 
                                           class="btn btn-sm btn-danger" title="Delete"
                                           onclick="return confirm('Delete this program?')">
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
                <i class="fas fa-graduation-cap"></i>
                <h4>No programs found</h4>
                <p>Add your first academic program to get started.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>