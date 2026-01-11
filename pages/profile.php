<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - AIU Alumni</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .dashboard-container { display: flex; gap: 2rem; max-width: 1200px; margin: 3rem auto; padding: 0 20px; }
        .sidebar-menu { width: 250px; background: white; border-radius: 12px; padding: 1.5rem; height: fit-content; box-shadow: var(--shadow); }
        .menu-item { display: block; padding: 12px 15px; color: #555; border-radius: 8px; margin-bottom: 5px; cursor: pointer; transition: 0.2s; }
        .menu-item:hover, .menu-item.active { background: #eef2f6; color: var(--primary); font-weight: 600; }
        .dashboard-content { flex: 1; }
        .profile-header { background: white; padding: 2rem; border-radius: 12px; display: flex; align-items: center; gap: 2rem; margin-bottom: 2rem; box-shadow: var(--shadow); }
        .avatar-large { width: 100px; height: 100px; background: #ddd; border-radius: 50%; border: 3px solid var(--secondary); }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">AIU ALUMNI.</div>
        <ul class="nav-links">
            <li><a href="jobs.html">Careers</a></li>
            <li><a href="events.html">Events</a></li>
            <li><a href="resources.html">Resources</a></li>
        </ul>
        <div class="auth-buttons">
            <span style="margin-right: 10px; align-self: center; font-weight: 600;">Hello, Ahmad</span>
            <a href="index.html" class="btn btn-outline" style="border-color: #ddd; color: #666;">Logout</a>
        </div>
    </nav>

    <div class="dashboard-container">
        <aside class="sidebar-menu">
            <div class="menu-item active">Dashboard</div>
            <div class="menu-item">My Applications</div>
            <div class="menu-item">Registered Events</div>
            <div class="menu-item">Update Profile</div>
            <div class="menu-item">Account Settings</div>
        </aside>

        <main class="dashboard-content">
            
            <div class="profile-header">
                <div class="avatar-large"></div>
                <div>
                    <h2 style="margin: 0;">Ahmad Albukhary</h2>
                    <p style="color: #666;">Class of 2021 • Bachelor in Business Administration</p>
                    <span class="tag" style="margin-top: 10px; display: inline-block;">Verified Alumnus</span>
                </div>
                <button class="btn btn-outline" style="margin-left: auto;">Edit</button>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                
                <div class="card">
                    <h3>Current Status</h3>
                    <div style="margin-top: 1rem;">
                        <p><strong>Job Title:</strong> Marketing Manager</p>
                        <p><strong>Company:</strong> Maybank</p>
                        <p><strong>Location:</strong> Kuala Lumpur, Malaysia</p>
                        <br>
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" checked>
                            <span style="font-size: 0.9rem;">Open to new opportunities</span>
                        </label>
                    </div>
                </div>

                <div class="card">
                    <h3>Recent Activity</h3>
                    <ul style="margin-top: 1rem; list-style: none;">
                        <li style="padding: 10px 0; border-bottom: 1px solid #eee;">
                            <span style="display: block; font-weight: 600;">Registered for Event</span>
                            <small style="color: #888;">Grand Homecoming Dinner</small>
                        </li>
                        <li style="padding: 10px 0; border-bottom: 1px solid #eee;">
                            <span style="display: block; font-weight: 600;">Applied for Job</span>
                            <small style="color: #888;">Software Engineer at Grab</small>
                        </li>
                        <li style="padding: 10px 0;">
                            <span style="display: block; font-weight: 600;">Updated Profile</span>
                            <small style="color: #888;">2 days ago</small>
                        </li>
                    </ul>
                </div>

            </div>
        </main>
    </div>

    <script src="js/main.js"></script>
</body>
</html>