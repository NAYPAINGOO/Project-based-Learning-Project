<?php
// Page configuration
$page_title = "Home";

// Optional JS for this page
$additional_js = ['../js/home.js'];

// Include header
include('../includes/header.php');
?>

<!-- HERO SECTION -->
<header class="hero">
    <div class="hero-content">
        <h1>Connect. Inspire.<br>Give Back.</h1>
        <p>
            Welcome to the official alumni network of Albukhary International University.
            Reconnect with batchmates, find career opportunities, and stay updated with your alma mater.
        </p>
        <div class="hero-cta">
            <a href="directory.php" class="btn btn-primary">Find Alumni</a>
            <a href="events.php" class="btn btn-outline" style="border-color: white; color: white;">
                Upcoming Events
            </a>
        </div>
    </div>
</header>

<!-- STATISTICS SECTION -->
<section class="stats-section">
    <div class="stat-item">
        <h2 class="counter" data-target="1500">0</h2>
        <p>Graduates</p>
    </div>
    <div class="stat-item">
        <h2 class="counter" data-target="52">0</h2>
        <p>Countries Represented</p>
    </div>
    <div class="stat-item">
        <h2 class="counter" data-target="120">0</h2>
        <p>Corporate Partners</p>
    </div>
    <div class="stat-item">
        <h2 class="counter" data-target="15">0</h2>
        <p>Years of Excellence</p>
    </div>
</section>

<!-- LATEST HAPPENINGS -->
<section class="container">
    <h2 class="section-title">Latest Happenings</h2>

    <div class="grid-3">
        <article class="card">
            <div class="card-image"></div>
            <span class="tag">Event</span>
            <h3>Global Alumni Meetup 2025</h3>
            <p>Join us at the main campus in Alor Setar for a night of networking and nostalgia.</p>
            <a href="events.php" class="read-more">Read More →</a>
        </article>

        <article class="card">
            <div class="card-image"></div>
            <span class="tag">News</span>
            <h3>AIU Launches New Tech Hub</h3>
            <p>
                The university has inaugurated a state-of-the-art AI research facility
                accessible to alumni startups.
            </p>
            <a href="news.php" class="read-more">Read More →</a>
        </article>

        <article class="card">
            <div class="card-image"></div>
            <span class="tag">Career</span>
            <h3>Exclusive Career Fair</h3>
            <p>Top companies are hiring directly from our alumni pool. Update your profile today.</p>
            <a href="jobs.php" class="read-more">Read More →</a>
        </article>
    </div>
</section>

<!-- ALUMNI SPOTLIGHT -->
<section class="alumni-spotlight">
    <div class="container spotlight-grid">
        <div>
            <img src="https://aiu.edu.my/wp-content/uploads/2022/08/AIU-Convocation-4.jpg"
                 alt="Alumni Spotlight">
        </div>

        <div>
            <h3>Sarah Ahmed</h3>
            <p class="batch">Class of 2018, Business Administration</p>
            <p class="quote">
                “AIU gave me the foundation to start my own social enterprise.
                The alumni network helped me secure my first seed funding.”
            </p>
            <a href="profile.php" class="btn btn-outline">View Profile</a>
        </div>
    </div>
</section>

<?php
// Include footer
include('../includes/footer.php');
?>
