<?php
require_once '../config/db.php';
requireLogin();

$conn = getDBConnection();
$user_id = $_SESSION['user_id'];

// Get user data
$sql = "SELECT a.*, p.program_name, ac.username, ac.account_status 
        FROM ALUMNI a 
        LEFT JOIN PROGRAM p ON a.program_id = p.program_id 
        LEFT JOIN ACCOUNT ac ON a.alumni_id = ac.alumni_id 
        WHERE a.alumni_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Get programs for dropdown
$programs_result = $conn->query("SELECT * FROM PROGRAM ORDER BY program_name");

$update_success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $full_name = $_POST['full_name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $current_job_title = $_POST['current_job_title'] ?? '';
    $address = $_POST['address'] ?? '';
    $program_id = $_POST['program_id'] ?? '';
    
    $update_sql = "UPDATE ALUMNI SET 
                   full_name = ?, 
                   phone = ?, 
                   current_job_title = ?, 
                   address = ?, 
                   program_id = ? 
                   WHERE alumni_id = ?";
    
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssii", 
        $full_name, 
        $phone, 
        $current_job_title, 
        $address, 
        $program_id, 
        $user_id
    );
    
    if ($update_stmt->execute()) {
        $_SESSION['full_name'] = $full_name;
        $update_success = true;
        // Refresh user data
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    } else {
        $error = 'Failed to update profile. Please try again.';
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>My Profile</h1>
    <p>Manage your alumni profile information</p>
</div>

<?php if ($update_success): ?>
    <div class="alert alert-success">Profile updated successfully!</div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<div class="profile-container">
    <div class="profile-sidebar">
        <div class="profile-picture">
            <i class="fas fa-user-circle"></i>
            <button class="btn btn-secondary btn-sm">Upload Photo</button>
        </div>
        
        <div class="profile-info">
            <h3><?php echo htmlspecialchars($user['full_name']); ?></h3>
            <p><i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($user['program_name'] ?? 'Not specified'); ?></p>
            <p><i class="fas fa-calendar"></i> Class of <?php echo htmlspecialchars($user['graduation_year']); ?></p>
            <p><i class="fas fa-user-check"></i> Account: <?php echo htmlspecialchars($user['account_status']); ?></p>
        </div>
        
        <div class="profile-stats">
            <h4>Profile Stats</h4>
            <div class="stat-item">
                <span>Events Attended</span>
                <strong>8</strong>
            </div>
            <div class="stat-item">
                <span>Applications</span>
                <strong>5</strong>
            </div>
            <div class="stat-item">
                <span>Feedback Given</span>
                <strong>3</strong>
            </div>
        </div>
    </div>
    
    <div class="profile-content">
        <form method="POST" action="">
            <div class="form-section">
                <h3>Personal Information</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" 
                               value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                        <small>Email cannot be changed</small>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="graduation_year">Graduation Year</label>
                        <input type="number" id="graduation_year" 
                               value="<?php echo htmlspecialchars($user['graduation_year']); ?>" disabled>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Academic Information</h3>
                <div class="form-group">
                    <label for="program_id">Academic Program</label>
                    <select id="program_id" name="program_id">
                        <option value="">Select Program</option>
                        <?php 
                        $programs_result->data_seek(0); // Reset pointer
                        while ($program = $programs_result->fetch_assoc()): 
                        ?>
                            <option value="<?php echo $program['program_id']; ?>"
                                <?php echo ($program['program_id'] == $user['program_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($program['program_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Professional Information</h3>
                <div class="form-group">
                    <label for="current_job_title">Current Job Title</label>
                    <input type="text" id="current_job_title" name="current_job_title" 
                           value="<?php echo htmlspecialchars($user['current_job_title'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="resume">Resume/CV</label>
                    <input type="file" id="resume" name="resume">
                    <?php if ($user['resume']): ?>
                        <small>Current: <a href="../uploads/resumes/<?php echo $user['resume']; ?>" target="_blank">View Resume</a></small>
                    <?php endif; ?>
                </div>
            </div>
            
            <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>