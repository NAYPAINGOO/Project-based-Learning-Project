<?php
require_once '../config/db.php';
requireAdmin();

$conn = getDBConnection();

// Handle job deletion
if (isset($_GET['delete'])) {
    $job_id = $_GET['delete'];
    $sql = "DELETE FROM JOB WHERE job_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    
    $_SESSION['message'] = "Job deleted successfully!";
    $_SESSION['message_type'] = 'success';
    header('Location: jobs.php');
    exit();
}

// Get jobs with company info and application counts
$sql = "SELECT j.*, c.company_name, 
        (SELECT COUNT(*) FROM JOB_APPLICATION WHERE job_id = j.job_id) as application_count
        FROM JOB j 
        LEFT JOIN COMPANY c ON j.company_id = c.company_id 
        ORDER BY j.posted_date DESC";
$result = $conn->query($sql);

// Get companies for filter
$companies_sql = "SELECT * FROM COMPANY ORDER BY company_name";
$companies_result = $conn->query($companies_sql);
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Manage Jobs</h1>
    <p>Post and manage job opportunities</p>
</div>

<div class="action-bar">
    <a href="?action=add" class="btn btn-success"><i class="fas fa-plus"></i> Post New Job</a>
    <a href="companies.php" class="btn btn-secondary"><i class="fas fa-building"></i> Manage Companies</a>
</div>

<div class="data-section">
    <div class="section-header">
        <h3>All Job Postings</h3>
        <div class="filter-controls">
            <select class="form-control" id="companyFilter">
                <option value="">All Companies</option>
                <?php while ($company = $companies_result->fetch_assoc()): ?>
                    <option value="<?php echo $company['company_id']; ?>">
                        <?php echo htmlspecialchars($company['company_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <select class="form-control" id="typeFilter">
                <option value="">All Types</option>
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
                <option value="Internship">Internship</option>
                <option value="Contract">Contract</option>
            </select>
        </div>
    </div>
    
    <?php if ($result->num_rows > 0): ?>
        <div class="jobs-list admin">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Applications</th>
                        <th>Posted Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($job = $result->fetch_assoc()): ?>
                        <tr data-company="<?php echo $job['company_id']; ?>" data-type="<?php echo $job['job_type']; ?>">
                            <td>
                                <strong><?php echo htmlspecialchars($job['job_title']); ?></strong><br>
                                <small><?php echo htmlspecialchars(substr($job['job_description'], 0, 50)); ?>...</small>
                            </td>
                            <td><?php echo htmlspecialchars($job['company_name']); ?></td>
                            <td>
                                <span class="badge badge-<?php 
                                    echo $job['job_type'] === 'Internship' ? 'info' : 
                                         ($job['job_type'] === 'Full-time' ? 'success' : 'warning'); 
                                ?>">
                                    <?php echo $job['job_type']; ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($job['job_location']); ?></td>
                            <td>
                                <span class="badge badge-info"><?php echo $job['application_count']; ?></span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($job['posted_date'])); ?></td>
                            <td>
                                <?php 
                                $status = 'Active';
                                if ($job['closing_date'] && strtotime($job['closing_date']) < time()) {
                                    $status = 'Closed';
                                }
                                ?>
                                <span class="badge badge-<?php echo $status === 'Active' ? 'success' : 'secondary'; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="?view=<?php echo $job['job_id']; ?>" class="btn btn-sm btn-secondary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="?edit=<?php echo $job['job_id']; ?>" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="job-applications.php?id=<?php echo $job['job_id']; ?>" class="btn btn-sm btn-info" title="Applications">
                                        <i class="fas fa-list"></i>
                                    </a>
                                    <a href="?delete=<?php echo $job['job_id']; ?>" class="btn btn-sm btn-danger" 
                                       title="Delete" onclick="return confirm('Delete this job?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-briefcase"></i>
            <h3>No jobs found</h3>
            <p>Post your first job opportunity to get started.</p>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>