<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIU Alumni - Careers</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Specific Styles for Job Layout */
        .jobs-layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }
        .filters {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            height: fit-content;
            position: sticky;
            top: 100px;
        }
        .filter-group { margin-bottom: 1.5rem; }
        .filter-group h4 { font-size: 1rem; margin-bottom: 0.5rem; color: var(--dark); }
        .checkbox-item { display: block; margin-bottom: 0.5rem; color: #666; cursor: pointer; }
        
        .job-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .search-bar {
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 50px;
            width: 300px;
        }
        @media (max-width: 768px) {
            .jobs-layout { grid-template-columns: 1fr; }
            .filters { display: none; /* Hide filters on mobile for now */ }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">AIU ALUMNI.</div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="events.html">Events</a></li>
            <li><a href="jobs.html" class="active">Careers</a></li>
            <li><a href="news.html">News</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
        <div class="auth-buttons">
            <a href="profile.html" class="btn btn-outline">My Profile</a>
        </div>
    </nav>

    <main class="container">
        <div class="job-header">
            <div>
                <h1>Career Opportunities</h1>
                <p>Exclusive jobs posted by alumni and partners.</p>
            </div>
            <input type="text" class="search-bar" placeholder="Search jobs, companies...">
        </div>

        <div class="jobs-layout">
            <aside class="filters">
                <div class="filter-group">
                    <h4>Job Type</h4>
                    <label class="checkbox-item"><input type="checkbox"> Full Time</label>
                    <label class="checkbox-item"><input type="checkbox"> Internship</label>
                    <label class="checkbox-item"><input type="checkbox"> Remote</label>
                </div>
                <div class="filter-group">
                    <h4>Location</h4>
                    <label class="checkbox-item"><input type="checkbox"> Malaysia</label>
                    <label class="checkbox-item"><input type="checkbox"> Singapore</label>
                    <label class="checkbox-item"><input type="checkbox"> International</label>
                </div>
                <button class="btn btn-primary" style="width: 100%; font-size: 0.9rem;">Apply Filters</button>
            </aside>

            <section class="job-list">
                
                <div class="card job-card" style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <h3>Software Engineer</h3>
                        <span style="color: var(--primary); font-weight: bold;">RM 4k - 6k</span>
                    </div>
                    <p style="margin-bottom: 0.5rem; color: #666;">Grab Malaysia • Kuala Lumpur</p>
                    <div class="tags">
                        <span class="tag">React</span>
                        <span class="tag">Node.js</span>
                    </div>
                    <p>We are looking for a talented AIU alumnus to join our backend team. You will be working on high-scale systems...</p>
                    <div style="margin-top: 1.5rem;">
                        <button class="btn btn-primary">Apply Now</button>
                        <button class="btn btn-outline" style="border: none;">Save Job</button>
                    </div>
                </div>

                <div class="card job-card" style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <h3>Marketing Executive</h3>
                        <span style="color: var(--primary); font-weight: bold;">RM 3k - 4k</span>
                    </div>
                    <p style="margin-bottom: 0.5rem; color: #666;">Petronas • Kedah</p>
                    <div class="tags">
                        <span class="tag">Social Media</span>
                        <span class="tag">SEO</span>
                    </div>
                    <p>Join the communications team. Ideal for Business Administration graduates with a flair for creative writing.</p>
                    <div style="margin-top: 1.5rem;">
                        <button class="btn btn-primary">Apply Now</button>
                        <button class="btn btn-outline" style="border: none;">Save Job</button>
                    </div>
                </div>

                <div class="card job-card" style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <h3>NGO Coordinator</h3>
                        <span style="color: var(--primary); font-weight: bold;">Volunteer</span>
                    </div>
                    <p style="margin-bottom: 0.5rem; color: #666;">Albukhary Foundation • Alor Setar</p>
                    <div class="tags">
                        <span class="tag">Social Work</span>
                        <span class="tag">Community</span>
                    </div>
                    <p>Lead community projects in the local area. A great opportunity to give back to the community.</p>
                    <div style="margin-top: 1.5rem;">
                        <button class="btn btn-primary">Apply Now</button>
                        <button class="btn btn-outline" style="border: none;">Save Job</button>
                    </div>
                </div>

            </section>
        </div>
    </main>

    <footer>
        <div class="copyright">&copy; 2025 AIU Alumni Association.</div>
    </footer>
    
    <script src="js/jobs.js"></script>
    <script src="js/main.js"></script>
</body>
</html>