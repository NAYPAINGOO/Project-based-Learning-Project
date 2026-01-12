<?php
require_once 'config/db.php';
require_once 'config/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $result = login($username, $password);
    
    if ($result === true) {
        if (isAdmin()) {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: user/dashboard.php');
        }
        exit();
    } elseif ($result === 'account_pending') {
        $error = 'Your account is pending approval. Please wait for administrator approval.';
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h2>Login to Alumni Portal</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        
        <div class="auth-links">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
            <p><a href="#">Forgot your password?</a></p>
        </div>
        
        <div class="demo-credentials">
            <h4>Demo Credentials:</h4>
            <p><strong>Admin:</strong> username: admin, password: demo123</p>
            <p><strong>User:</strong> Register a new account</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>