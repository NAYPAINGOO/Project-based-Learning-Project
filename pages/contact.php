<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - AIU Alumni</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">AIU ALUMNI.</div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="events.html">Events</a></li>
            <li><a href="contact.html" class="active">Contact</a></li>
        </ul>
        <div class="auth-buttons"><a href="login.html" class="btn btn-outline">Log In</a></div>
    </nav>

    <header class="hero" style="height: 40vh;">
        <div class="hero-content">
            <h1>Get in Touch</h1>
            <p>Have questions about the portal, transcripts, or visiting campus? We are here to help.</p>
        </div>
    </header>

    <section class="container" style="margin-top: -50px; position: relative; z-index: 10;">
        <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-wrap: wrap;">
            
            <div style="flex: 1; background: var(--primary); color: white; padding: 3rem; min-width: 300px;">
                <h3 style="color: white; margin-bottom: 2rem;">Contact Information</h3>
                
                <div style="margin-bottom: 2rem;">
                    <h5 style="color: var(--secondary);">Address</h5>
                    <p>Student Affairs Department,<br>Albukhary International University,<br>Jalan Tun Abdul Razak, 05200 Alor Setar,<br>Kedah, Malaysia.</p>
                </div>

                <div style="margin-bottom: 2rem;">
                    <h5 style="color: var(--secondary);">Email</h5>
                    <p>alumni@aiu.edu.my</p>
                    <p>registrar@aiu.edu.my</p>
                </div>

                <div style="margin-bottom: 2rem;">
                    <h5 style="color: var(--secondary);">Phone</h5>
                    <p>+60 4-774 7474</p>
                </div>

                <div style="display: flex; gap: 15px; margin-top: 3rem;">
                    <div style="width: 30px; height: 30px; background: rgba(255,255,255,0.2); border-radius: 50%;"></div>
                    <div style="width: 30px; height: 30px; background: rgba(255,255,255,0.2); border-radius: 50%;"></div>
                </div>
            </div>

            <div style="flex: 1.5; padding: 3rem; background: white; min-width: 300px;">
                <h3 style="margin-bottom: 1.5rem;">Send us a Message</h3>
                <form>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <select style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                            <option>General Inquiry</option>
                            <option>Transcript Request</option>
                            <option>Job Posting Help</option>
                            <option>Report Technical Issue</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea rows="5" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                    </div>
                    <button class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <div style="height: 50px;"></div>
    <footer>
        <div class="copyright">&copy; 2025 AIU Alumni Association.</div>
    </footer>
    <script src="js/main.js"></script>
</body>
</html>