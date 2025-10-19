<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();

$db = new Database();
$conn = $db->connect();

$user = getEmployeeData($conn, $_SESSION['employee_id']);
$stats = getTicketStats($conn, $_SESSION['employee_id']);

$filter = $_GET['filter'] ?? 'all';
$search = $_GET['search'] ?? '';

$query = "SELECT * FROM tickets WHERE employee_id = :employee_id";
$params = ['employee_id' => $_SESSION['employee_id']];

if ($filter !== 'all') {
    $query .= " AND LOWER(status) = :status";
    $params['status'] = strtolower($filter);
}

if ($search) {
    $query .= " AND (LOWER(title) LIKE :search OR LOWER(ticket_number) LIKE :search)";
    $params['search'] = '%' . strtolower($search) . '%';
}

$query .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($query);
$stmt->execute($params);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets - HR System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1>MY TICKETS</h1>
            <div class="user-info">
                <img src="assets/images/avatar.png" alt="Avatar" class="avatar">
                <span><?php echo htmlspecialchars($user['full_name']); ?></span>
            </div>
        </div>
        
        <div class="ticket-header">
            <a href="create_ticket.php" class="btn btn-primary">Create New Ticket</a>
        </div>
        
        <div class="ticket-stats">
            <div class="stat-card">
                <div class="stat-label">TOTAL TICKETS</div>
                <div class="stat-value"><?php echo $stats['total']; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">PENDING</div>
                <div class="stat-value"><?php echo $stats['pending']; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">IN PROGRESS</div>
                <div class="stat-value"><?php echo $stats['in_progress']; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">RESOLVED</div>
                <div class="stat-value"><?php echo $stats['resolved']; ?></div>
            </div>
        </div>
        
        <div class="ticket-filters">
            <input type="text" id="search-tickets" placeholder="Search tickets..." value="<?php echo htmlspecialchars($search); ?>" class="search-input">
            <select id="filter-status" class="filter-select">
                <option value="all" <?php echo $filter === 'all' ? 'selected' : ''; ?>>All Status</option>
                <option value="pending" <?php echo $filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="in progress" <?php echo $filter === 'in progress' ? 'selected' : ''; ?>>In Progress</option>
                <option value="resolved" <?php echo $filter === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                <option value="closed" <?php echo $filter === 'closed' ? 'selected' : ''; ?>>Closed</option>
            </select>
        </div>
        
        <div class="tickets-list">
            <?php if (empty($tickets)): ?>
                <p class="no-tickets">No tickets found.</p>
            <?php else: ?>
                <?php foreach ($tickets as $ticket): ?>
                    <div class="ticket-item">
                        <div class="ticket-info">
                            <h3>
                                <a href="ticket_detail.php?id=<?php echo $ticket['id']; ?>" style="color: #333; text-decoration: none;">
                                    <?php echo htmlspecialchars($ticket['title']); ?>
                                </a>
                            </h3>
                            <p><?php echo htmlspecialchars(substr($ticket['description'], 0, 100)); ?>...</p>
                            <div class="ticket-meta">
                                <span class="ticket-number"><?php echo htmlspecialchars($ticket['ticket_number']); ?></span>
                                <span class="badge <?php echo getPriorityClass($ticket['priority']); ?>"><?php echo htmlspecialchars($ticket['priority']); ?></span>
                                <span class="ticket-category"><?php echo htmlspecialchars($ticket['category']); ?></span>
                                <span class="ticket-date"><?php echo date('M d, Y', strtotime($ticket['created_at'])); ?></span>
                            </div>
                            <div class="ticket-assigned">Assigned to: <?php echo htmlspecialchars($ticket['assigned_to']); ?></div>
                        </div>
                        <div class="ticket-status">
                            <span class="badge <?php echo getStatusClass($ticket['status']); ?>"><?php echo strtoupper($ticket['status']); ?></span>
                            <a href="ticket_detail.php?id=<?php echo $ticket['id']; ?>" class="btn btn-sm btn-secondary" style="margin-top: 10px;">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <button class="chatbot-toggle" id="chatbot-toggle">💬 Help</button>
    <div class="chatbot-window" id="chatbot-window">
        <div class="chatbot-header">
            <span>🤖 HR Assistant</span>
            <button id="close-chatbot">✕</button>
        </div>
        <div class="chatbot-messages" id="chatbot-messages"></div>
        <div class="chatbot-input">
            <input type="text" id="chatbot-input" placeholder="Type your question...">
            <button id="send-message">Send</button>
        </div>
    </div>
    
    <script src="assets/js/tickets.js"></script>
    <script src="assets/js/chatbot.js"></script>
</body>
</html>
