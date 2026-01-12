<?php
require_once '../config/db.php';
requireLogin();

$conn = getDBConnection();
$user_id = $_SESSION['user_id'];

// Get job categories/types
$job_types = ['Full-time', 'Part-time', 'Internship', 'Contract'];

// Get companies for filter
$companies_result = $conn->query("SELECT company_id, company_name FROM COMPANY ORDER BY company_name");

// Get active jobs
$where_conditions = [];
$params = [];
$types = "";

if (isset($_GET['type']) && $_GET['type']) {
    $where_conditions[] = "j.job_type = ?";
    $params[] = $_GET['type'];
    $types .= "s";
}

if (isset($_GET['company']) && $_GET['company']) {
    $where_conditions[] = "j.company_id = ?";
    $params[] = $_GET['company'];
    $types .= "i";
}

$where_sql = $where_conditions ? "WHERE " . implode(" AND ", $where_conditions) : "";
$jobs_sql = "SELECT j.*, c.company_name, 
             (SELECT COUNT(*) FROM JOB_APPLICATION WHERE job_id = j.job_id) as application_count,
             (SELECT application_status FROM JOB_APPLICATION WHERE job_id = j.job_id AND alumni_id = ?) as user_application
             FROM JOB j 
             LEFT JOIN COMPANY c ON j.company_id = c.company_id 
             $where_sql 
             AND (j.closing_date IS NULL OR j.closing_date >= CURDATE()) 
             ORDER BY j.posted_date DESC";

$jobs_stmt = $conn->prepare($jobs_sql);
if ($params) {
    $jobs_stmt->bind_param($types . "i", ...array_merge($params, [$user_id]));
} else {
    $jobs_stmt->bind_param("i", $user_id);
}
$jobs_stmt->execute();
$jobs_result = $jobs_stmt->get_result();
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Job Opportunities</h1>
    <p>Find career opportunities posted by companies</p>
</div>

<div class="jobs-container">
    <div class="jobs-sidebar">
        <div class="filter-card">
            <h3>Filters</h3>
            <form method="GET" action="">
                <div class="form-group">
                    <label>Job Type</label>
                    <select name="type" class="form-control">
                        <option value="">All Types</option>
                        <?php foreach ($job_types as $type): ?>
                            <option value="<?php echo $type; ?>" <?php echo (isset($_GET['type']) && $_GET['type'] === $type) ? 'selected' : ''; ?>>
                                <?php echo $type; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Company</label>
                    <select name="company" class="form-control">
                        <option value="">All Companies</option>
                        <?php while ($company = $companies_result->fetch_assoc()): ?>
                            <option value="<?php echo $company['company_id']; ?>" 
                                <?php echo (isset($_GET['company']) && $_GET['company'] == $company['company_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($company['company_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Apply Filters</button>
                <a href="jobs.php" class="btn btn-secondary btn-block">Clear Filters</a>
            </form>
        </div>
        
        <div class="quick-stats">
            <h3>Quick Stats</h3>
            <div class="stat-item">
                <span>Active Jobs</span>
                <strong><?php echo $jobs_result->num_rows; ?></strong>
            </div>
            <div class="stat-item">
                <span>Your Applications</span>
                <strong>3</strong>
            </div>
            <div class="stat-item">
                <span>Companies</span>
                <strong><?php echo $companies_result->num_rows; ?></strong>
            </div>
        </div>
    </div>
    
    <div class="jobs-content">
        <?php if ($jobs_result->num_rows > 0): ?>
            <div class="jobs-grid">
                <?php while ($job = $jobs_result->fetch_assoc()): ?>
                    <div class="job-card">
                        <div class="job-header">
                            <div>
                                <h3><?php echo htmlspecialchars($job['job_title']); ?></h3>
                                <p class="company-name">
                                    <i class="fas fa-building"></i>
                                    <?php echo htmlspecialchars($job['company_name']); ?>
                                </p>
                            </div>
                            <span class="job-type badge badge-<?php 
                                echo $job['job_type'] === 'Internship' ? 'info' : 
                                     ($job['job_type'] === 'Full-time' ? 'success' : 'warning'); 
                            ?>">
                                <?php echo $job['job_type']; ?>
                            </span>
                        </div>
                        
                        <div class="job-body">
                            <div class="job-details">
                                <div class="detail">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?php echo htmlspecialchars($job['job_location']); ?>
                                </div>
                                <div class="detail">
                                    <i class="fas fa-users"></i>
                                    <?php echo $job['application_count']; ?> applicants
                                </div>
                                <div class="detail">
                                    <i class="fas fa-calendar"></i>
                                    Posted: <?php echo date('M d, Y', strtotime($job['posted_date'])); ?>
                                </div>
                                <?php if ($job['closing_date']): ?>
                                <div class="detail">
                                    <i class="fas fa-clock"></i>
                                    Closes: <?php echo date('M d, Y', strtotime($job['closing_date'])); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <p class="job-description">
                                <?php echo htmlspecialchars(substr($job['job_description'], 0, 150)); ?>...
                            </p>
                        </div>
                        
                        <div class="job-footer">
                            <?php if ($job['user_application']): ?>
                                <span class="badge badge-<?php 
                                    echo $job['user_application'] === 'Accepted' ? 'success' : 
                                         ($job['user_application'] === 'Rejected' ? 'danger' : 'info'); 
                                ?>">
                                    <?php echo $job['user_application']; ?>
                                </span>
                            <?php else: ?>
                                <a href="apply-job.php?id=<?php echo $job['job_id']; ?>" class="btn btn-primary">Apply Now</a>
                            <?php endif; ?>
                            <a href="job-details.php?id=<?php echo $job['job_id']; ?>" class="btn btn-secondary">View Details</a>
                            <button class="btn btn-outline btn-save" data-job-id="<?php echo $job['job_id']; ?>">
                                <i class="far fa-bookmark"></i> Save
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-briefcase"></i>
                <h3>No jobs found</h3>
                <p>Try adjusting your filters or check back later.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>