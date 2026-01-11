<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - AIU Alumni</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .event-date-badge {
            background: var(--primary);
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            min-width: 70px;
            margin-right: 1.5rem;
        }
        .event-day { font-size: 1.5rem; font-weight: 700; line-height: 1; display: block; }
        .event-month { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; }
        .jobs-layout { display: grid; grid-template-columns: 250px 1fr; gap: 2rem; margin-top: 2rem; }
        .filters { background: white; padding: 1.5rem; border-radius: 12px; height: fit-content; }
        .checkbox-item { display: block; margin-bottom: 0.5rem; color: #666; cursor: pointer; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">AIU ALUMNI.</div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="events.html" class="active">Events</a></li>
            <li><a href="jobs.html">Careers</a></li>
            <li><a href="news.html">News</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
        <div class="auth-buttons"><a href="profile.html" class="btn btn-outline">My Profile</a></div>
    </nav>

    <main class="container">
        <h1 class="section-title" style="margin-bottom: 1rem;">Upcoming Events</h1>
        <p style="text-align: center; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto;">
            Register for workshops, reunions, and networking sessions exclusively for AIU graduates.
        </p>

        <div class="jobs-layout">
            <aside class="filters">
                <h3>Filter Events</h3>
                <br>
                <div style="margin-bottom: 1.5rem;">
                    <h4 style="margin-bottom: 0.5rem;">Category</h4>
                    <label class="checkbox-item"><input type="checkbox" checked> All</label>
                    <label class="checkbox-item"><input type="checkbox"> Reunions</label>
                    <label class="checkbox-item"><input type="checkbox"> Career Workshops</label>
                    <label class="checkbox-item"><input type="checkbox"> Social Business</label>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <h4 style="margin-bottom: 0.5rem;">Format</h4>
                    <label class="checkbox-item"><input type="checkbox"> Physical (Alor Setar)</label>
                    <label class="checkbox-item"><input type="checkbox"> Virtual (Zoom)</label>
                </div>
            </aside>

            <section class="event-list">
                
                <article class="card" style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                    <div class="event-date-badge">
                        <span class="event-day">15</span>
                        <span class="event-month">NOV</span>
                    </div>
                    <div style="flex: 1;">
                        <span class="tag" style="background: #e6f7ff; color: #0077b6;">Reunion</span>
                        <h3 style="margin: 0.5rem 0;">Annual Grand Homecoming Dinner</h3>
                        <p style="color: #666; font-size: 0.9rem;">📍 Dewan Canselor, AIU Campus • 8:00 PM</p>
                    </div>
                    <div>
                        <a href="#" class="btn btn-primary">Register</a>
                    </div>
                </article>

                <article class="card" style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                    <div class="event-date-badge" style="background: var(--secondary); color: var(--dark);">
                        <span class="event-day">02</span>
                        <span class="event-month">DEC</span>
                    </div>
                    <div style="flex: 1;">
                        <span class="tag" style="background: #f0fdf4; color: #166534;">Webinar</span>
                        <h3 style="margin: 0.5rem 0;">Mastering Social Entrepreneurship</h3>
                        <p style="color: #666; font-size: 0.9rem;">🎥 Zoom • 10:00 AM (MYT)</p>
                    </div>
                    <div>
                        <a href="#" class="btn btn-outline">Details</a>
                    </div>
                </article>

                 <article class="card" style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                    <div class="event-date-badge" style="background: #333;">
                        <span class="event-day">10</span>
                        <span class="event-month">JAN</span>
                    </div>
                    <div style="flex: 1;">
                        <span class="tag" style="background: #fff1f2; color: #be123c;">Workshop</span>
                        <h3 style="margin: 0.5rem 0;">CV Clinic & Interview Prep</h3>
                        <p style="color: #666; font-size: 0.9rem;">🎥 Google Meet • 2:00 PM (MYT)</p>
                    </div>
                    <div>
                        <a href="#" class="btn btn-outline">Details</a>
                    </div>
                </article>

            </section>
        </div>
    </main>

    <script src="js/events.js"></script>
    <script src="js/main.js"></script>
</body>
</html>