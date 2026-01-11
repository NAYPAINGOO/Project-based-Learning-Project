<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News & Stories - AIU Alumni</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .featured-news {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 4rem;
        }
        .featured-img {
            height: 400px;
            background: #ddd url('images/news-hero.jpg') center/cover;
            border-radius: 16px;
            position: relative;
        }
        .news-overlay {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding: 2rem;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            border-radius: 0 0 16px 16px;
            color: white;
        }
        .sidebar-news h4 { border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; }
        .mini-news-item { display: flex; gap: 10px; margin-bottom: 15px; }
        .mini-thumb { width: 80px; height: 80px; background: #eee; border-radius: 8px; object-fit: cover; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">AIU ALUMNI.</div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="events.html">Events</a></li>
            <li><a href="jobs.html">Careers</a></li>
            <li><a href="news.html" class="active">News</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
        <div class="auth-buttons"><a href="login.html" class="btn btn-outline">Log In</a></div>
    </nav>

    <div class="container">
        <h1 class="section-title">Campus & Alumni News</h1>

        <section class="featured-news">
            <div class="featured-img">
                <div class="news-overlay">
                    <span class="tag" style="background: var(--secondary); color: black;">Highlight</span>
                    <h2 style="color: white; font-size: 2rem; margin-top: 10px;">AIU Ranked Among Top Universities for Social Impact</h2>
                    <p>The latest rankings highlight the university's commitment to community service and social business education.</p>
                </div>
            </div>
            <div class="sidebar-news">
                <h4>Trending Now</h4>
                
                <div class="mini-news-item">
                    <div class="mini-thumb" style="background: gray;"></div>
                    <div>
                        <h5 style="margin: 0; font-size: 0.95rem;">Alumnus Wins National Award</h5>
                        <small style="color: #888;">2 hours ago</small>
                    </div>
                </div>

                <div class="mini-news-item">
                    <div class="mini-thumb" style="background: #ccc;"></div>
                    <div>
                        <h5 style="margin: 0; font-size: 0.95rem;">New Library Wing Opens</h5>
                        <small style="color: #888;">1 day ago</small>
                    </div>
                </div>

                <div class="mini-news-item">
                    <div class="mini-thumb" style="background: #999;"></div>
                    <div>
                        <h5 style="margin: 0; font-size: 0.95rem;">Vice Chancellor's Address</h5>
                        <small style="color: #888;">3 days ago</small>
                    </div>
                </div>
            </div>
        </section>

        <h3 style="border-left: 5px solid var(--primary); padding-left: 1rem; margin-bottom: 2rem;">Latest Stories</h3>
        <div class="grid-3">
            <article class="card">
                <div style="height: 200px; background: #eee; border-radius: 8px; margin-bottom: 1rem;"></div>
                <h3>Convocation 2024 Highlights</h3>
                <p>Relive the best moments from the graduation ceremony held last week.</p>
                <a href="#" style="color: var(--primary); font-weight: bold;">Read Article</a>
            </article>
            <article class="card">
                <div style="height: 200px; background: #eee; border-radius: 8px; margin-bottom: 1rem;"></div>
                <h3>Social Business Challenge</h3>
                <p>Students and Alumni collaborate to solve local economic issues in Kedah.</p>
                <a href="#" style="color: var(--primary); font-weight: bold;">Read Article</a>
            </article>
            <article class="card">
                <div style="height: 200px; background: #eee; border-radius: 8px; margin-bottom: 1rem;"></div>
                <h3>Scholarship Fund Update</h3>
                <p>How your contributions are helping the next generation of scholars.</p>
                <a href="#" style="color: var(--primary); font-weight: bold;">Read Article</a>
            </article>
        </div>
    </div>

    <footer>
        <div class="copyright">&copy; 2025 AIU Alumni Association.</div>
    </footer>
    <script src="js/main.js"></script>
</body>
</html>