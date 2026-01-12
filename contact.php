<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    
    // In a real application, you would send an email here
    // For now, we'll just show a success message
    
    $_SESSION['message'] = "Thank you for your message! We'll get back to you soon.";
    $_SESSION['message_type'] = 'success';
    header('Location: contact.php');
    exit();
}
?>
<?php include 'includes/header.php'; ?>

<div class="page-header">
    <h1>Contact Us</h1>
</div>

<div class="contact-container">
    <div class="contact-info">
        <h2>Get in Touch</h2>
        <div class="contact-item">
            <i class="fas fa-map-marker-alt"></i>
            <div>
                <h3>Address</h3>
                <p>Albukhary International University<br>
                Jalan Tun Abdul Razak<br>
                05200 Alor Setar, Kedah<br>
                Malaysia</p>
            </div>
        </div>
        <div class="contact-item">
            <i class="fas fa-phone"></i>
            <div>
                <h3>Phone</h3>
                <p>+60 4-123 4567</p>
            </div>
        </div>
        <div class="contact-item">
            <i class="fas fa-envelope"></i>
            <div>
                <h3>Email</h3>
                <p>alumni@aiu.edu.my</p>
            </div>
        </div>
    </div>
    
    <div class="contact-form">
        <h2>Send us a Message</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject *</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="message">Message *</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>