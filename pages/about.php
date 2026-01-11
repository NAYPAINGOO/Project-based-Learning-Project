<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - AIU Alumni</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .timeline { position: relative; max-width: 800px; margin: 0 auto; }
        .timeline::after { content: ''; position: absolute; width: 2px; background: var(--secondary); top: 0; bottom: 0; left: 50%; margin-left: -1px; }
        .timeline-item { padding: 10px 40px; position: relative; width: 50%; box-sizing: border-box; }
        .timeline-item::after { content: ''; position: absolute; width: 20px; height: 20px; right: -10px; background: white; border: 4px solid var(--primary); top: 15px; border-radius: 50%; z-index: 1; }
        .left { left: 0; text-align: right; }
        .right { left: 50%; }
        .right::after { left: -10px; }
        
        @media screen and (max-width: 600px) {
            .timeline::after { left: 31px; }
            .timeline-item { width: 100%; padding-left: 70px; padding-right: 25px; }
            .timeline-item::after { left: 21px; }
            .left { text-align: left; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">AIU ALUMNI.</div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html" class="active">About</a></li>
            <li><a href="events.html">Events</a></li>
            <li><a href="jobs.html">Careers</a></li>
            <li><a href="news.html">News</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
        <div class="auth-buttons"><a href="login.html" class="btn btn-outline">Log In</a></div>
    </nav>


    <header class="hero" style="height: 60vh; background-image: url('images/aiu-aerial.jpg');">
        <div class="hero-content">
            <h1>Our Legacy & Future</h1>
            <p>Uniting the global community of Albukhary International University graduates under one banner of Adab and Altruism.</p>
        </div>
    </header>

    <section class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
            <div>
                <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Who We Are</h2>
                <p style="margin-bottom: 1.5rem; font-size: 1.1rem; color: #555;">
                    The AIU Alumni Association is an independent organization committed to fostering a lifelong connection between the university and its graduates. We believe that graduation is not the end, but the beginning of a lifelong journey of giving back to society.
                </p>
                <div style="background: #fdf8e8; padding: 2rem; border-left: 5px solid var(--secondary); border-radius: 8px;">
                    <h4 style="color: var(--primary);">Our Mission</h4>
                    <p>To build a robust network of social entrepreneurs and leaders who embody the 5As (Adab, Akhlaq, Amanah, Altruism, Abundance) and contribute significantly to global peace and prosperity.</p>
                </div>
            </div>
            <div>
                <img src="https://www.aiuniv.edu/media/default/AIU/images/misc/houston.jpg" alt="AIU Campus Life" style="border-radius: 16px; box-shadow: var(--shadow);">
            </div>
        </div>
    </section>

    <section style="background: var(--light); padding: 5rem 0;">
        <div class="container">
            <h2 class="section-title">Our History</h2>
            <div class="timeline">
                <div class="timeline-item left">
                    <div class="card">
                        <h3>2010</h3>
                        <p>Albukhary International University was established by the Albukhary Foundation.</p>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="card">
                        <h3>2014</h3>
                        <p>First Convocation Ceremony held at the majestic Dewan Canselor.</p>
                    </div>
                </div>
                <div class="timeline-item left">
                    <div class="card">
                        <h3>2018</h3>
                        <p>Re-establishment of the university with a renewed focus on Social Business.</p>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="card">
                        <h3>2025</h3>
                        <p>Launch of the Digital Alumni Portal connecting over 50 countries.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="copyright">&copy; 2025 AIU Alumni Association.</div>
    </footer>
    <script src="js/main.js"></script>
</body>
</html>