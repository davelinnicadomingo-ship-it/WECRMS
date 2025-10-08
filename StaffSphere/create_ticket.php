<?php
require_once 'config/database.php';
require_once 'config/session.php';
requireLogin();

$db = new Database();
$categories = $db->fetchAll("SELECT * FROM ticket_categories ORDER BY category_name");

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $priority = $_POST['priority'] ?? 'medium';
    
    if ($title && $description && $category_id) {
        $ticket_number = 'TKT-' . date('Ymd') . '-' . substr(uniqid(), -6);
        
        $result = $db->query(
            "INSERT INTO tickets (ticket_number, employee_id, category_id, title, description, priority, status) 
             VALUES (?, ?, ?, ?, ?, ?, 'pending')",
            [$ticket_number, getUserId(), $category_id, $title, $description, $priority]
        );
        
        if ($result) {
            $ticket_id = $db->lastInsertId();
            
            $db->query(
                "INSERT INTO status_history (ticket_id, new_status, updated_by) VALUES (?, 'pending', ?)",
                [$ticket_id, getUserId()]
            );
            
            $success = "Ticket created successfully! Ticket Number: $ticket_number";
        } else {
            $error = 'Failed to create ticket. Please try again.';
        }
    } else {
        $error = 'Please fill in all required fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ticket - Employee Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Create New Ticket</h1>
            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>">
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-help">Choose the category that best matches your concern or request</small>
                </div>
                
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" required placeholder="Brief summary of your concern">
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" required rows="6" 
                              placeholder="Provide detailed information about your concern or request"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select id="priority" name="priority">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Submit Ticket</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="chatbot-toggle" onclick="toggleChatbot()">
        💬 Help
    </div>
    
    <?php include 'includes/chatbot.php'; ?>
    
    <script src="assets/js/main.js"></script>
</body>
</html>
