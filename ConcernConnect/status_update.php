<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();

$db = new Database();
$conn = $db->connect();

$user = getEmployeeData($conn, $_SESSION['employee_id']);
$status_counts = getStatusCounts($conn, $_SESSION['employee_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Update - HR System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1>STATUS UPDATE</h1>
            <div class="user-info">
                <img src="assets/images/avatar.png" alt="Avatar" class="avatar">
                <span><?php echo htmlspecialchars($user['full_name']); ?></span>
            </div>
        </div>
        
        <div class="status-update-container">
            <h2>Progress Tracking</h2>
            
            <div class="status-report-large">
                <div class="status-item-large" style="background: #3B82F6;">
                    <div class="status-count-large"><?php echo $status_counts['days']; ?></div>
                    <div class="status-label-large">Days Active</div>
                </div>
                <div class="status-item-large" style="background: #10B981;">
                    <div class="status-count-large"><?php echo $status_counts['completed']; ?></div>
                    <div class="status-label-large">Completed Tasks</div>
                </div>
                <div class="status-item-large" style="background: #F59E0B;">
                    <div class="status-count-large"><?php echo $status_counts['in_progress']; ?></div>
                    <div class="status-label-large">In Progress</div>
                </div>
            </div>
            
            <div class="timeline">
                <h3>Recent Activity</h3>
                <div class="timeline-item">
                    <div class="timeline-marker completed"></div>
                    <div class="timeline-content">
                        <strong>Task Completed</strong>
                        <p>Equipment request processed</p>
                        <span class="timeline-date">2 hours ago</span>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-marker in-progress"></div>
                    <div class="timeline-content">
                        <strong>In Progress</strong>
                        <p>Leave request under review</p>
                        <span class="timeline-date">5 hours ago</span>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-marker pending"></div>
                    <div class="timeline-content">
                        <strong>Pending</strong>
                        <p>Payroll query submitted</p>
                        <span class="timeline-date">1 day ago</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
