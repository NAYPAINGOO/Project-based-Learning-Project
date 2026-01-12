<?php
require_once '../config/db.php';
requireLogin();

$conn = getDBConnection();
$user_id = $_SESSION['user_id'];

// Get user's job applications
$sql = "SELECT ja.*, j.job_title, j.job_type, j.job_location, c.company_name 
        FROM JOB_APPLICATION ja 
        JOIN JOB j ON ja.job_id = j.job_id 
        JOIN COMPANY c ON j.company_id = c.company_id 
        WHERE ja.alumni_id = ? 
        ORDER BY ja.application_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<?php include '../includes/header.php'; ?>

<div class="page-header">
    <h1>My Applications</h1>
    <p>Track your job applications</p>
</div>

<div class="applications-container">
    <?php if ($result->num_rows > 0): ?>
        <div class="applications-stats">
            <div class="stat-card">
                <div class="stat-icon pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3>
                        <?php
                        $pending_sql = "SELECT COUNT(*) as count FROM JOB_APPLICATION 
                                       WHERE alumni_id = ? AND application_status = 'Pending'";
                        $pending_stmt = $conn->prepare($pending_sql);
                        $pending_stmt->bind_param("i", $user_id);
                        $pending_stmt->execute();
                        $pending_result = $pending_stmt->get_result();
                        echo $pending_result->fetch_assoc()['count'];
                        ?>
                    </h3>
                    <p>Pending</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon reviewed">
                    <i class="fas fa-search"></i>
                </div>
                <div class="stat-content">
                    <h3>
                        <?php
                        $reviewed_sql = "SELECT COUNT(*) as count FROM JOB_APPLICATION 
                                        WHERE alumni_id = ? AND application_status = 'Reviewed'";
                        $reviewed_stmt = $conn->prepare($reviewed_sql);
                        $reviewed_stmt->bind_param("i", $user_id);
                        $reviewed_stmt->execute();
                        $reviewed_result = $reviewed_stmt->get_result();
                        echo $reviewed_result->fetch_assoc()['count'];
                        ?>
                    </h3>
                    <p>Reviewed</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon accepted">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>
                        <?php
                        $accepted_sql = "SELECT COUNT(*) as count FROM JOB_APPLICATION 
                                        WHERE alumni_id = ? AND application_status = 'Accepted'";
                        $accepted_stmt = $conn->prepare($accepted_sql);
                        $accepted_stmt->bind_param("i", $user_id);
                        $accepted_stmt->execute();
                        $accepted_result = $accepted_stmt->get_result();
                        echo $accepted_result->fetch_assoc()['count'];
                        ?>
                    </h3>
                    <p>Accepted</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon rejected">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>
                        <?php
                        $rejected_sql = "SELECT COUNT(*) as count FROM JOB_APPLICATION 
                                        WHERE alumni_id = ? AND application_status = 'Rejected'";
                        $rejected_stmt = $conn->prepare($rejected_sql);
                        $rejected_stmt->bind_param("i", $user_id);
                        $rejected_stmt->execute();
                        $rejected_result = $rejected_stmt->get_result();
                        echo $rejected_result->fetch_assoc()['count'];
                        ?>
                    </h3>
                    <p>Rejected</p>
                </div>
            </div>
        </div>
        
        <div class="applications-list">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Type</th>
                        <th>Applied Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($application = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($application['job_title']); ?></strong><br>
                                <small><?php echo htmlspecialchars($application['job_location']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($application['company_name']); ?></td>
                            <td><?php echo $application['job_type']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($application['application_date'])); ?></td>
                            <td>
                                <span class="badge badge-<?php 
                                    echo $application['application_status'] === 'Accepted' ? 'success' : 
                                         ($application['application_status'] === 'Rejected' ? 'danger' : 
                                         ($application['application_status'] === 'Reviewed' ? 'warning' : 'info')); 
                                ?>">
                                    <?php echo $application['application_status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="job-details.php?id=<?php echo $application['job_id']; ?>" class="btn btn-sm btn-secondary">View</a>
                                <?php if ($application['application_status'] === 'Pending'): ?>
                                    <a href="?withdraw=<?php echo $application['application_id']; ?>" class="btn btn-sm btn-warning">Withdraw</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-file-alt"></i>
            <h3>No applications yet</h3>
            <p>You haven't applied for any jobs yet. <a href="jobs.php">Browse jobs</a> to get started.</p>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>