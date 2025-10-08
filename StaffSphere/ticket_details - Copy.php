<?php
require_once 'config/database.php';
require_once 'config/session.php';
requireLogin();

$db = new Database();
$ticket_id = $_GET['id'] ?? 0;

$ticket = $db->fetchOne(
    "SELECT t.*, tc.category_name, e.full_name, e.email, e.department,
            a.full_name as assigned_name
     FROM tickets t
     JOIN ticket_categories tc ON t.category_id = tc.id
     JOIN employees e ON t.employee_id = e.id
     LEFT JOIN employees a ON t.assigned_to = a.id
     WHERE t.id = ?",
    [$ticket_id]
);

if (!$ticket || ($ticket['employee_id'] != getUserId() && !isHR())) {
    header('Location: index.php');
    exit();
}

$status_history = $db->fetchAll(
    "SELECT sh.*, e.full_name 
     FROM status_history sh
     JOIN employees e ON sh.updated_by = e.id
     WHERE sh.ticket_id = ?
     ORDER BY sh.created_at DESC",
    [$ticket_id]
);

$responses = $db->fetchAll(
    "SELECT tr.*, e.full_name, e.role 
     FROM ticket_responses tr
     JOIN employees e ON tr.employee_id = e.id
     WHERE tr.ticket_id = ?
     ORDER BY tr.created_at ASC",
    [$ticket_id]
);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['response_text'])) {
    $response_text = $_POST['response_text'];
    
    if ($response_text) {
        $db->query(
            "INSERT INTO ticket_responses (ticket_id, employee_id, response_text) VALUES (?, ?, ?)",
            [$ticket_id, getUserId(), $response_text]
        );
        
        header("Location: ticket_details.php?id=$ticket_id");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Details - <?php echo htmlspecialchars($ticket['ticket_number']); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Ticket #<?php echo htmlspecialchars($ticket['ticket_number']); ?></h1>
            <a href="<?php echo isHR() ? 'hr_dashboard.php' : 'index.php'; ?>" class="btn btn-secondary">Back</a>
        </div>
        
        <div class="ticket-details-grid">
            <div class="ticket-main">
                <div class="ticket-info-card">
                    <h2><?php echo htmlspecialchars($ticket['title']); ?></h2>
                    <div class="ticket-status-header">
                        <span class="status-badge status-<?php echo $ticket['status']; ?>">
                            <?php echo ucfirst(str_replace('_', ' ', $ticket['status'])); ?>
                        </span>
                        <span class="priority-badge priority-<?php echo $ticket['priority']; ?>">
                            <?php echo ucfirst($ticket['priority']); ?> Priority
                        </span>
                    </div>
                    <p class="ticket-description"><?php echo nl2br(htmlspecialchars($ticket['description'])); ?></p>
                    
                    <div class="ticket-meta-details">
                        <p><strong>Category:</strong> <?php echo htmlspecialchars($ticket['category_name']); ?></p>
                        <p><strong>Created by:</strong> <?php echo htmlspecialchars($ticket['full_name']); ?> (<?php echo htmlspecialchars($ticket['department']); ?>)</p>
                        <p><strong>Created on:</strong> <?php echo date('F d, Y h:i A', strtotime($ticket['created_at'])); ?></p>
                        <?php if ($ticket['assigned_name']): ?>
                            <p><strong>Assigned to:</strong> <?php echo htmlspecialchars($ticket['assigned_name']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="responses-section">
                    <h3>Responses & Updates</h3>
                    
                    <?php foreach ($responses as $response): ?>
                        <div class="response-card <?php echo $response['role'] === 'hr_admin' ? 'hr-response' : ''; ?>">
                            <div class="response-header">
                                <strong><?php echo htmlspecialchars($response['full_name']); ?></strong>
                                <?php if ($response['role'] === 'hr_admin'): ?>
                                    <span class="hr-badge">HR</span>
                                <?php endif; ?>
                                <span class="response-time"><?php echo date('M d, Y h:i A', strtotime($response['created_at'])); ?></span>
                            </div>
                            <p><?php echo nl2br(htmlspecialchars($response['response_text'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                    
                    <?php if (empty($responses)): ?>
                        <p class="no-responses">No responses yet.</p>
                    <?php endif; ?>
                    
                    <form method="POST" class="response-form">
                        <textarea name="response_text" placeholder="Add a response..." rows="3" required></textarea>
                        <button type="submit" class="btn btn-primary">Submit Response</button>
                    </form>
                </div>
            </div>
            
            <div class="ticket-sidebar">
                <div class="status-tracker">
                    <h3>Status History</h3>
                    <div class="timeline">
                        <?php foreach ($status_history as $history): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <p class="timeline-status">
                                        <?php if ($history['old_status']): ?>
                                            <?php echo ucfirst(str_replace('_', ' ', $history['old_status'])); ?> → 
                                        <?php endif; ?>
                                        <strong><?php echo ucfirst(str_replace('_', ' ', $history['new_status'])); ?></strong>
                                    </p>
                                    <p class="timeline-user">by <?php echo htmlspecialchars($history['full_name']); ?></p>
                                    <p class="timeline-date"><?php echo date('M d, Y h:i A', strtotime($history['created_at'])); ?></p>
                                    <?php if ($history['notes']): ?>
                                        <p class="timeline-notes"><?php echo htmlspecialchars($history['notes']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="assets/js/main.js"></script>
</body>
</html>
