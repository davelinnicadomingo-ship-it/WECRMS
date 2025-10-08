<?php
require_once 'config/database.php';
require_once 'config/session.php';
requireHR();

$db = new Database();

$tickets = $db->fetchAll(
    "SELECT t.*, tc.category_name, e.full_name, e.department, a.full_name as assigned_name
     FROM tickets t
     LEFT JOIN ticket_categories tc ON t.category_id = tc.id
     LEFT JOIN employees e ON t.employee_id = e.id
     LEFT JOIN employees a ON t.assigned_to = a.id
     ORDER BY 
        CASE t.status 
            WHEN 'pending' THEN 1 
            WHEN 'in_progress' THEN 2 
            ELSE 3 
        END,
        t.created_at DESC"
);

$stats = $db->fetchOne(
    "SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
        SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved,
        SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as closed
     FROM tickets"
);

$hr_staff = $db->fetchAll("SELECT id, full_name FROM employees WHERE role = 'hr_admin'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Management Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="dashboard-header">
            <h1>HR Management Dashboard</h1>
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
            <div class="stat-card stat-closed">
                <h3>Closed</h3>
                <p class="stat-number"><?php echo $stats['closed'] ?? 0; ?></p>
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
            <select id="categoryFilter" class="filter-select">
                <option value="">All Categories</option>
                <?php
                $categories = $db->fetchAll("SELECT DISTINCT category_name FROM ticket_categories");
                foreach ($categories as $cat):
                ?>
                    <option value="<?php echo htmlspecialchars($cat['category_name']); ?>">
                        <?php echo htmlspecialchars($cat['category_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="tickets-list" id="ticketsList">
            <?php foreach ($tickets as $ticket): ?>
                <div class="ticket-card hr-ticket" 
                     data-status="<?php echo htmlspecialchars($ticket['status']); ?>"
                     data-category="<?php echo htmlspecialchars($ticket['category_name']); ?>">
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
                    <div class="ticket-employee">
                        <p><strong>Employee:</strong> <?php echo htmlspecialchars($ticket['full_name']); ?> (<?php echo htmlspecialchars($ticket['department']); ?>)</p>
                        <?php if ($ticket['assigned_name']): ?>
                            <p><strong>Assigned to:</strong> <?php echo htmlspecialchars($ticket['assigned_name']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="ticket-actions">
                        <select class="status-select" onchange="updateTicketStatus(<?php echo $ticket['id']; ?>, this.value)">
                            <option value="">Update Status</option>
                            <option value="pending" <?php echo $ticket['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="in_progress" <?php echo $ticket['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="resolved" <?php echo $ticket['status'] === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                            <option value="closed" <?php echo $ticket['status'] === 'closed' ? 'selected' : ''; ?>>Closed</option>
                        </select>
                        <select class="assign-select" onchange="assignTicket(<?php echo $ticket['id']; ?>, this.value)">
                            <option value="">Assign To</option>
                            <?php foreach ($hr_staff as $staff): ?>
                                <option value="<?php echo $staff['id']; ?>" 
                                        <?php echo $ticket['assigned_to'] == $staff['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($staff['full_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <?php if (empty($tickets)): ?>
                <div class="empty-state">
                    <p>No tickets found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="assets/js/main.js"></script>
    <script src="assets/js/hr.js"></script>
</body>
</html>
