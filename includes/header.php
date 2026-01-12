<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIU Alumni Portal</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <a href="../index.php">
                    <i class="fas fa-university"></i>
                    AIU Alumni Portal
                </a>
            </div>
            
            <div class="nav-menu">
                <a href="../index.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
                <a href="../about.php" class="nav-link"><i class="fas fa-info-circle"></i> About</a>
                <a href="../contact.php" class="nav-link"><i class="fas fa-envelope"></i> Contact</a>
                
                <?php if (isLoggedIn()): ?>
                    <?php if (isAdmin()): ?>
                        <a href="../admin/dashboard.php" class="nav-link"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a>
                    <?php else: ?>
                        <a href="../user/dashboard.php" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <?php endif; ?>
                    <a href="../user/profile.php" class="nav-link"><i class="fas fa-user"></i> Profile</a>
                    <a href="../logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
                <?php else: ?>
                    <a href="../login.php" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <a href="../register.php" class="nav-link"><i class="fas fa-user-plus"></i> Register</a>
                <?php endif; ?>
            </div>
            
            <button class="nav-toggle" id="navToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <main class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>