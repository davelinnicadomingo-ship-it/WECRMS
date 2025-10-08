<?php
require_once 'config/database.php';
require_once 'config/session.php';
requireLogin();

$db = new Database();

$tickets = $db->fetchAll(
    "SELECT t.*, tc.category_name, e.full_name as assigned_name 
     FROM tickets t 
     LEFT JOIN ticket_categories tc ON t.category_id = tc.id
     LEFT JOIN employees e ON t.assigned_to = e.id
     WHERE t.employee_id = ?
     ORDER BY t.created_at DESC",
    [getUserId()]
);

$stats = $db->fetchOne(
    "SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
        SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved
     FROM tickets WHERE employee_id = ?",
    [getUserId()]
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets - Employee Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="dashboard-header">
            <h1>My Tickets</h1>
            <a href="create_ticket.php" class="btn btn-primary">Create New Ticket</a>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Tickets</h3>
                <p class="stat-number"><?php echo $stats['total'] ?? 0; ?></p>
            </div>
            <div class="stat-card stat-pending">
                <h3>Pending</h3>
                <p class="stat-number"><?php echo $stats['pending'] ?? 0; ?></p>
            </div>
            <div class="stat-card stat-progress">
                <h3>In Progress</h3>
                <p class="stat-number"><?php echo $stats['in_progress'] ?? 0; ?></p>
            </div>
            <div class="stat-card stat-resolved">
                <h3>Resolved</h3>
                <p class="stat-number"><?php echo $stats['resolved'] ?? 0; ?></p>
            </div>
        </div>
        
        <div class="filter-bar">
            <input type="text" id="searchTicket" placeholder="Search tickets..." class="search-input">
            <select id="statusFilter" class="filter-select">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="resolved">Resolved</option>
                <option value="closed">Closed</option>
            </select>
        </div>
        
        <div class="tickets-list" id="ticketsList">
            <?php foreach ($tickets as $ticket): ?>
                <div class="ticket-card" data-status="<?php echo htmlspecialchars($ticket['status']); ?>">
                    <div class="ticket-header">
                        <h3>
                            <a href="ticket_details.php?id=<?php echo $ticket['id']; ?>">
                                <?php echo htmlspecialchars($ticket['title']); ?>
                            </a>
                        </h3>
                        <span class="status-badge status-<?php echo $ticket['status']; ?>">
                            <?php echo ucfirst(str_replace('_', ' ', $ticket['status'])); ?>
                        </span>
                    </div>
                    <p class="ticket-description"><?php echo htmlspecialchars(substr($ticket['description'], 0, 150)) . '...'; ?></p>
                    <div class="ticket-meta">
                        <span class="ticket-number">#<?php echo htmlspecialchars($ticket['ticket_number']); ?></span>
                        <span class="ticket-category"><?php echo htmlspecialchars($ticket['category_name']); ?></span>
                        <span class="ticket-priority priority-<?php echo $ticket['priority']; ?>">
                            <?php echo ucfirst($ticket['priority']); ?>
                        </span>
                        <span class="ticket-date"><?php echo date('M d, Y', strtotime($ticket['created_at'])); ?></span>
                    </div>
                    <?php if ($ticket['assigned_name']): ?>
                        <p class="ticket-assigned">Assigned to: <?php echo htmlspecialchars($ticket['assigned_name']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            
            <?php if (empty($tickets)): ?>
                <div class="empty-state">
                    <p>No tickets found. Create your first ticket to get started!</p>
                    <a href="create_ticket.php" class="btn btn-primary">Create Ticket</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="chatbot-toggle" onclick="toggleChatbot()">
        💬 Help
    </div>
    
    <?php include 'includes/chatbot.php'; ?>
    
    <script src="assets/js/main.js"></script>
</body>
</html>
