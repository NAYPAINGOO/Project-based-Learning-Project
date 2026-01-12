<?php
require_once 'config/db.php';
require_once 'config/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$success = false;
$error = '';

// Get programs for dropdown
$conn = getDBConnection();
$programs_result = $conn->query("SELECT * FROM PROGRAM ORDER BY program_name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'full_name' => $_POST['full_name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'graduation_year' => $_POST['graduation_year'] ?? '',
        'program_id' => $_POST['program_id'] ?? '',
        'current_job_title' => $_POST['current_job_title'] ?? '',
        'address' => $_POST['address'] ?? '',
        'username' => $_POST['username'] ?? '',
        'password' => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? ''
    ];
    
    // Validate passwords match
    if ($data['password'] !== $data['confirm_password']) {
        $error = 'Passwords do not match.';
    } else {
        $result = registerAlumni($data);
        
        if ($result) {
            $success = true;
            $_SESSION['message'] = "Registration successful! Your account is pending approval. You'll be notified once approved.";
            $_SESSION['message_type'] = 'success';
            header('Location: login.php');
            exit();
        } else {
            $error = 'Registration failed. Please try again.';
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h2>Register as Alumni</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!$success): ?>
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group">
                    <label for="full_name">Full Name *</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone">
                </div>
                
                <div class="form-group">
                    <label for="graduation_year">Graduation Year *</label>
                    <input type="number" id="graduation_year" name="graduation_year" min="2000" max="<?php echo date('Y'); ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="program_id">Academic Program *</label>
                <select id="program_id" name="program_id" required>
                    <option value="">Select Program</option>
                    <?php while ($program = $programs_result->fetch_assoc()): ?>
                        <option value="<?php echo $program['program_id']; ?>">
                            <?php echo htmlspecialchars($program['program_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="current_job_title">Current Job Title</label>
                <input type="text" id="current_job_title" name="current_job_title">
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3"></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Username *</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        
        <div class="auth-links">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>