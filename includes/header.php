<?php
// Start session for user authentication
session_start();

// Get current page for active navigation
$current_page = basename($_SERVER['PHP_SELF']);

// Set default page title if not defined
if (!isset($page_title)) {
    $page_title = 'AIU Alumni Portal';
}

// Set default additional CSS/JS if not defined
$additional_css = $additional_css ?? [];
$additional_js = $additional_js ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - AIU Alumni Network</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Additional CSS Files -->
    <?php foreach($additional_css as $css_file): ?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($css_file); ?>">
    <?php endforeach; ?>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">AIU ALUMNI.</div>
        
        <ul class="nav-links">
            <li><a href="index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a></li>
            <li><a href="about.php" class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About</a></li>
            <li><a href="events.php" class="<?php echo $current_page == 'events.php' ? 'active' : ''; ?>">Events</a></li>
            <li><a href="jobs.php" class="<?php echo $current_page == 'jobs.php' ? 'active' : ''; ?>">Careers</a></li>
            <li><a href="news.php" class="<?php echo $current_page == 'news.php' ? 'active' : ''; ?>">News</a></li>
            <li><a href="resources.php" class="<?php echo $current_page == 'resources.php' ? 'active' : ''; ?>">Resources</a></li>
            <li><a href="contact.php" class="<?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
        </ul>
        
        <div class="auth-buttons">
            <?php if(isset($_SESSION['user_id'])): ?>
                <!-- Show when user is logged in -->
                <div class="user-menu">
                    <a href="profile.php" class="btn btn-outline">
                        <i class="fas fa-user"></i> My Profile
                    </a>
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                </div>
            <?php else: ?>
                <!-- Show when user is not logged in -->
                <a href="login.php" class="btn btn-outline">Log In</a>
                <a href="register.php" class="btn btn-primary">Join Network</a>
            <?php endif; ?>
        </div>
        
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
    </nav>
    
    <!-- Main Content Container -->
    <main>