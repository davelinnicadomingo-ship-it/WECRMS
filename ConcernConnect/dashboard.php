<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();

$db = new Database();
$conn = $db->connect();

$user = getEmployeeData($conn, $_SESSION['employee_id']);
$stats = getTicketStats($conn, $_SESSION['employee_id']);
$status_counts = getStatusCounts($conn, $_SESSION['employee_id']);
$recent_tickets = getRecentTickets($conn, $_SESSION['employee_id'], 3);
$chat_history = getChatHistory($conn, $_SESSION['employee_id'], 5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HR System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .top-header {
      background: #fff;
      border-radius: 12px;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .shift-box {
      background: linear-gradient(135deg, #5f4ef7, #8b67f8);
      color: #fff;
      border-radius: 20px;
      padding: 30px;
      text-align: center;
    }
    .status-circle {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: #eee;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      margin: auto;
    }
  </style>
</head>
<body>
  <?php include 'includes/sidebar.php'; ?>

  <div class="main-content">
    <!-- Top Header -->
    <div class="top-header mb-4">
      <h4 class="">Hello <strong><?php echo $_SESSION['full_name']; ?></strong>, Good Morning!</h4>
      <div class="d-flex align-items-center">
        <button class="btn btn-link d-lg-none" id="sidebarToggle">
          <i class="bi bi-list"></i>
        </button>
        <div class="header-actions ms-auto d-flex align-items-center">
          <button class="btn btn-link me-3"><i class="bi bi-bell"></i></button>
          <div class="dropdown">
            <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
              <img src="images/lunod.jpg" alt="Employee" class="rounded-circle me-2" width="32" height="32">
              <?php echo $_SESSION['full_name']; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="employee_profile.php">Profile</a></li>
              <li><a class="dropdown-item" href="#">Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="login.php">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="dashboard-grid">
      <div class="dashboard-left">
        <div class="company-card">
          <h3>Trusting Social AI Philippines</h3>
          <div class="time-display">
            <div class="time" id="current-time">10:42</div>
            <div class="shift-info">Shift Duration: 06h 18min</div>
            <button class="btn btn-light">Check out</button>
          </div>
        </div>

        <div class="status-report">
          <h3>Status Report</h3>
          <div class="status-grid">
            <div class="status-item" style="background: #3B82F6;">
              <div class="status-count"><?php echo $status_counts['days']; ?></div>
              <div class="status-label">Days</div>
            </div>
            <div class="status-item" style="background: #10B981;">
              <div class="status-count"><?php echo $status_counts['completed']; ?></div>
              <div class="status-label">Completed Task</div>
            </div>
            <div class="status-item" style="background: #F59E0B;">
              <div class="status-count"><?php echo $status_counts['in_progress']; ?></div>
              <div class="status-label">In Progress</div>
            </div>
          </div>
        </div>
      </div>

      <div class="dashboard-right">
        <div class="chat-section">
          <h3>Previous chat with AI</h3>
          <div class="chat-history" id="chat-history">
            <?php foreach ($chat_history as $msg): ?>
              <div class="chat-message <?php echo $msg['is_bot'] ? 'bot' : 'user'; ?>">
                <strong><?php echo $msg['is_bot'] ? 'AI:' : 'User:'; ?></strong>
                <?php echo htmlspecialchars($msg['message']); ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="team-member">
          <div class="avatar-circle">AA</div>
          <div class="member-info">
            <strong>Alek Almene</strong>
            <div>Financial Support</div>
            <div>employee00@example.com</div>
            <div>Joined: June 2023</div>
          </div>
        </div>

        <div class="calendar-widget">
          <div class="calendar-header">
            <select id="month-select">
              <option>Month</option>
            </select>
            <select id="year-select">
              <option>Year</option>
            </select>
          </div>
          <div id="calendar"></div>
        </div>

        <div class="upcoming-events">
          <h4>Upcoming Events</h4>
          <?php foreach ($recent_tickets as $ticket): ?>
            <div class="event-item">
              <div class="event-date">
                <?php echo date('M d', strtotime($ticket['created_at'])); ?><br>
                <?php echo date('g:ia', strtotime($ticket['created_at'])); ?>
              </div>
              <div class="event-details">
                <strong><?php echo htmlspecialchars($ticket['title']); ?></strong>
                <div><?php echo htmlspecialchars($ticket['category']); ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
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
    <div class="chatbot-quick">
      <p>Quick Questions:</p>
      <button class="quick-btn" data-msg="leave">Leave Request</button>
      <button class="quick-btn" data-msg="payroll">Payroll Info</button>
      <button class="quick-btn" data-msg="benefits">Benefits</button>
    </div>
  </div>

  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/chatbot.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
