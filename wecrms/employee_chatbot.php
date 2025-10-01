<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];

include 'db_connect2.php'; // <-- your DB connection file (do not modify)

// --- Determine user id (preferred) ---
$userId = null;
if (isset($_SESSION['id'])) {
    $userId = (int)$_SESSION['id'];
} else 
    // try to resolve from users table using username or email
    if ($stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1")) {
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $stmt->bind_result($foundId);
        if ($stmt->fetch()) $userId = (int)$foundId;
        $stmt->close();
    } else 


// --- Handle POST (user submitted a message) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $msg = trim($_POST['message']);
    if ($msg !== '') {
        // Insert user message
        $ins = $conn->prepare("INSERT INTO chat_messages (id, sender, message) VALUES (?, 'user', ?)");
        if ($ins === false) {
            die("SQL prepare failed (insert user message): " . $conn->error);
        }
        // allow null id if unknown
        if ($userId === null) {
            // bind_param expects variables; set temporary null int as 0 and pass null using bind_param won't work - so use explicit NULL query
            $ins2 = $conn->prepare("INSERT INTO chat_messages (id, sender, message) VALUES (NULL, 'user', ?)");
            if ($ins2 === false) {
                die("SQL prepare failed (insert user message null user): " . $conn->error);
            }
            $ins2->bind_param("s", $msg);
            $ins2->execute();
            $ins2->close();
            $lastUserMsgId = $conn->insert_id;
        } else {
            $ins->bind_param("is", $userId, $msg);
            $ins->execute();
            $ins->close();
            $lastUserMsgId = $conn->insert_id;
        }

        // --- generate a bot reply server-side and insert it ---
        $lower = strtolower($msg);
        $botReply = "🤖 Thanks for your message! We'll get back to you soon.";

        if (stripos($lower, "hello") !== false || stripos($lower, "hi") !== false) {
            $botReply = "👋 Hello {$username}! How can I assist you today?";
        } elseif (stripos($lower, "ticket") !== false) {
            // include an interactive link/button (HTML). We'll save HTML to DB so it renders as clickable link.
            $botReply = '🎫 You can create a new ticket here: <a href="new_ticket.php" class="btn btn-sm btn-primary" target="_self">Create Ticket</a>';
        } elseif (stripos($lower, "attendance") !== false) {
            $botReply = '📅 You can mark your attendance here: <a href="employee_attendance.php" class="btn btn-sm btn-primary" target="_self">Mark Attendance</a>';
        } elseif (stripos($lower, "profile") !== false) {
            $botReply = '👤 Visit your profile: <a href="employee_profile.php" class="btn btn-sm btn-primary" target="_self">Open Profile</a>';
        } // add more rules as you like

        // Insert bot reply
        $insb = $conn->prepare("INSERT INTO chat_messages (id, sender, message) VALUES (?, 'bot', ?)");
        if ($insb === false) {
            die("SQL prepare failed (insert bot message): " . $conn->error);
        }
        if ($userId === null) {
            $insb2 = $conn->prepare("INSERT INTO chat_messages (id, sender, message) VALUES (NULL, 'bot', ?)");
            if ($insb2 === false) die("SQL prepare failed (insert bot null user): " . $conn->error);
            $insb2->bind_param("s", $botReply);
            $insb2->execute();
            $insb2->close();
        } else {
            $insb->bind_param("is", $userId, $botReply);
            $insb->execute();
            $insb->close();
        }

        // redirect to avoid resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// --- Fetch messages for display (for this user) ---
$messages = [];
$getSql = "SELECT sender, message, created_at FROM chat_messages WHERE (id = ? OR id IS NULL) ORDER BY created_at ASC";
$stmt = $conn->prepare($getSql);
if ($stmt === false) {
    die("SQL prepare failed (fetch messages): " . $conn->error);
}
$uid_for_bind = $userId === null ? 0 : $userId;
$stmt->bind_param("i", $uid_for_bind);
$stmt->execute();
$res = $stmt->get_result();
while ($r = $res->fetch_assoc()) {
    $messages[] = $r;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Chatbot — Employee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
    /* keep your styles — minimal additions for message layout */
    .main { margin-left: 260px; padding: 2rem; }
    .chat-container { background: #fff; border-radius: 15px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); overflow: hidden; }
    .chat-header { background: linear-gradient(90deg, #6a11cb, #2575fc); color: white; padding: 1rem; display:flex; align-items:center; }
    .chat-messages { height: 300px; overflow-y: auto; padding: 1rem; background: #f8faff; display:flex; flex-direction:column; gap:.5rem; }
    .message { display:inline-block; background:#e6ebf5; border-radius:12px; padding:.6rem 1rem; max-width:80%; }
    .message.user { margin-left:auto; background:#d1e7ff; }
    .message.bot { align-self:flex-start; background:#f0f2f9; }
    .quick-buttons button { margin-right:10px; margin-bottom:10px; }
    .chat-input { border-top:1px solid #ddd; display:flex; align-items:center; padding:.5rem; }
    .chat-input input { flex:1; border:none; padding:.7rem; border-radius:10px; background:#f1f3f7; margin-right:10px; }
    .side-section { background:#fff; border-radius:15px; padding:1rem; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <!-- Sidebar (kept exactly as you provided earlier) -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="brand-section">
                <h4 class="brand-title">Trusting<br>Social AI<br>Philippines</h4>
                <div class="admin-profile">
                    <img src="lunod.jpg" alt="Employee" class="admin-avatar-img">
                    <h6 class="admin-name"><?php echo htmlspecialchars($_SESSION['username']); ?></h6>
                </div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="employee_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="employee_profile.php"><i class="bi bi-person"></i> Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="employee_attendance.php"><i class="bi bi-calendar-check"></i> Attendance</a></li>
                <li class="nav-item"><a class="nav-link" href="employee_status.php"><i class="bi bi-graph-up"></i> Status Update</a></li>
                <li class="nav-item"><a class="nav-link" href="new_ticket.php"><i class="bi bi-ticket"></i> Tickets</a></li>
                <li class="nav-item"><a class="nav-link active" href="employee_chatbot.php"><i class="bi bi-robot"></i> Chatbot</a></li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="employee_settings.php"><i class="bi bi-gear"></i> Settings</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main">
      <h3 class="fw-bold">Chatbot</h3>
      <p class="text-muted">Get instant help with common HR questions and ticket management!</p>

      <div class="row g-4">
        <div class="col-lg-8">
          <div class="chat-container d-flex flex-column">
            <!-- HEADER -->
            <div class="chat-header">
              <img src="bot-avatar.png" alt="Bot" style="width:45px;height:45px;border-radius:50%;margin-right:10px;">
              <div>
                <h6 class="mb-0">Chatbot Assistant</h6>
                <small>🟢 Online</small>
              </div>
            </div>

            <!-- MESSAGES - filled from DB -->
            <div class="chat-messages" id="chatMessages">
              <?php if (empty($messages)): ?>
                <div class="message bot">Hello <?php echo htmlspecialchars($username); ?>! I’m your Assistant. How can I assist you?</div>
              <?php else: ?>
                <?php foreach ($messages as $m): ?>
                  <?php
                    $cls = ($m['sender'] === 'user') ? 'message user' : 'message bot';
                    // For bot messages we preserved HTML (for buttons/links). For user messages, escape.
                    if ($m['sender'] === 'bot') {
                        // output bot message as-is (trusted); if you want to sanitize, adjust here.
                        $content = $m['message'];
                    } else {
                        $content = htmlspecialchars($m['message']);
                    }
                  ?>
                  <div class="<?php echo $cls; ?>">
                    <?php echo $content; ?>
                    <div style="font-size:11px;color:#666;margin-top:4px;"><?php echo date("M j, H:i", strtotime($m['created_at'])); ?></div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>

            <!-- QUICK BUTTONS -->
            <div class="p-3 quick-buttons">
              <form method="post" style="display:inline;">
                <input type="hidden" name="message" value="ID Request">
                <button type="submit" class="btn btn-outline-secondary btn-sm">ID Request</button>
              </form>
              <form method="post" style="display:inline;">
                <input type="hidden" name="message" value="ID Lost or Access Card">
                <button type="submit" class="btn btn-outline-secondary btn-sm">ID Lost or Access Card</button>
              </form>
              <form method="post" style="display:inline;">
                <input type="hidden" name="message" value="Notary Request">
                <button type="submit" class="btn btn-outline-secondary btn-sm">Notary Request</button>
              </form>
              <form method="post" style="display:inline;">
                <input type="hidden" name="message" value="Others">
                <button type="submit" class="btn btn-outline-secondary btn-sm">Others</button>
              </form>
            </div>

            <!-- INPUT: user can press Enter to submit -->
            <form method="post" id="chatForm">
              <div class="chat-input">
                <input type="text" name="message" id="userInput" placeholder="Type your message..." autocomplete="off" />
                <button class="btn btn-primary" type="submit"><i class="bi bi-send"></i></button>
              </div>
            </form>
          </div>
        </div>

        <!-- SIDE PANELS -->
        <div class="col-lg-4 d-flex flex-column gap-4">
          <div class="side-section">
            <h6 class="fw-bold">Common Questions</h6>
            <ul class="list-unstyled mt-3">
              <li><i class="bi bi-calendar-event me-2"></i> What are the company holidays?</li>
              <li><i class="bi bi-person-gear me-2"></i> How do I update my personal data?</li>
              <li><i class="bi bi-hospital me-2"></i> What is the sick leave policy?</li>
            </ul>
          </div>
          <div class="side-section">
            <h6 class="fw-bold">Quick Actions</h6>
            <a class="btn btn-primary w-100 my-2" href="new_ticket.php">+ Create New Ticket</a>
            <a class="btn btn-success w-100 my-2" href="tickets_list.php"> Check Ticket Status</a>
            <a class="btn btn-danger w-100 my-2" href="hr_policies.php"> View HR Policies</a>
          </div>
        </div>
      </div>
    </div>

<!-- minimal JS only to keep scroll at bottom after page loads -->
<script>
  (function(){
    var box = document.getElementById('chatMessages');
    if (box) box.scrollTop = box.scrollHeight;
    // pressing Enter in the input will submit the form by default
    var input = document.getElementById('userInput');
    if (input) input.addEventListener('keydown', function(e){
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        this.form.submit();
      }
    });
  })();
</script>

</body>
</html>
