<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header("Location: login.php");
    exit();
}

include 'db_connect2.php';

// 🧠 Get logged-in employee
$user_email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT id, name, phone FROM employees WHERE email = ?");
if (!$stmt) { die("Prepare failed: " . $conn->error); }
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

if (!$employee) {
    die("Employee not found.");
}

$employee_id = $employee['id'];

// 📝 Get the latest ticket for this employee
$ticket_stmt = $conn->prepare("SELECT * FROM tickets WHERE employee_id = ? ORDER BY created_at DESC LIMIT 1");
if (!$ticket_stmt) { die("Prepare failed: " . $conn->error); }
$ticket_stmt->bind_param("i", $employee_id);
$ticket_stmt->execute();
$ticket_result = $ticket_stmt->get_result();
$ticket = $ticket_result->fetch_assoc();

// Set progress based on status
$progress = 0;
$steps = [];
if ($ticket) {
    switch (strtolower($ticket['status'])) {
        case 'open':
            $progress = 20;
            $steps = ['Ticket submitted'];
            break;
        case 'in progress':
            $progress = 60;
            $steps = ['Ticket submitted', 'Department is processing', 'Waiting for approval'];
            break;
        case 'on hold':
            $progress = 40;
            $steps = ['Ticket submitted', 'Currently on hold'];
            break;
        case 'completed':
            $progress = 100;
            $steps = ['Ticket submitted', 'Processed by department', 'Approved', 'Completed & closed'];
            break;
        default:
            $progress = 0;
            $steps = ['Ticket created'];
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        .profile-card {
            background: #fff; border-radius: 10px;
            padding: 20px; margin-bottom: 20px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
            position: relative;
        }
        .profile-header img { width: 70px; height: 70px; border-radius: 50%; margin-right: 15px; }
        .profile-header h5 { margin: 0; }
        .info-label { font-weight: bold; color: #555; }
        .info-value { margin-bottom: 10px; }
        .ellipsis-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }
        .dropdown-menu {
            min-width: auto;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="brand-section">
                <h4 class="brand-title">Trusting<br>Social AI<br>Philippines</h4>
                <div class="admin-profile">
                    <img src="images/lunod.jpg" alt="Employee" class="admin-avatar-img">
                    <h6 class="admin-name"><?php echo $_SESSION['username'] ?></h6> <!-- ✅ show username -->
                </div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="employee_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="employee_profile.php"><i class="bi bi-person"></i> Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="employee_attendance.php"><i class="bi bi-calendar-check"></i> Attendance</a></li>
                <li class="nav-item"><a class="nav-link active" href="employee_status.php"><i class="bi bi-graph-up"></i> Status Update</a></li>
                <li class="nav-item"><a class="nav-link" href="new_ticket.php"><i class="bi bi-ticket"></i> Tickets</a></li>
                <li class="nav-item"><a class="nav-link" href="employee_chatbot.php"><i class="bi bi-robot"></i> Chatbot</a></li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="employee_setttings.php"><i class="bi bi-gear"></i> Settings</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Profile Content -->
     <div class="main-content">
        <header class="top-header d-flex align-items-center">
            <button class="btn btn-link d-lg-none" id="sidebarToggle"><i class="bi bi-list"></i></button>
            <div class="header-actions ms-auto d-flex align-items-center">
                <button class="btn btn-link me-3"><i class="bi bi-bell"></i></button>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <img src="images/lunod.jpg" alt="Employee" class="rounded-circle me-2" width="32" height="32">
                        <?php echo $_SESSION['username']; ?> <!-- ✅ -->
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="employee_profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="employee_settings.php">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="login.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>
<div class="container mt-4" style="margin-left:270px; max-width:850px;">
    <h3 class="mb-4">Status Update</h3>

    <?php if ($ticket): ?>
    <div class="profile-card">
        <div class="d-flex align-items-center mb-4">
            <img src="alk.png" alt="Employee" class="rounded-circle me-2" width="32" height="32">
            <div>
                <h5><?php echo htmlspecialchars($employee['name']); ?></h5>
                <p class="text-muted mb-0"><?php echo htmlspecialchars($employee['phone']); ?></p>
            </div>
            <button 
  class="btn btn-outline-primary ms-auto" 
  onclick="window.location.href='employee_chatbot.php'">
  <i class="bi bi-robot"></i> Chat with Chatbot
</button>
        </div>

        <h4 class="mb-3"><?php echo htmlspecialchars($ticket['title']); ?></h4>
        <p class="text-muted"><?php echo htmlspecialchars($ticket['description']); ?></p>

        <div class="progress-bar-bg mb-4">
            <div class="progress-bar-fill" style="width:<?php echo $progress; ?>%"></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Status:</strong> <?php echo htmlspecialchars($ticket['status']); ?></p>
                <p><strong>Priority:</strong> <?php echo htmlspecialchars($ticket['priority']); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Date submitted:</strong> <?php echo date("F j, Y g:i A", strtotime($ticket['created_at'])); ?></p>
                <p><strong>Department:</strong> Security</p>
            </div>
        </div>

        <h5>What’s next?</h5>
        <p class="text-muted">We’ll notify you as soon as it’s done.</p>

        <div class="mt-3">
            <?php foreach ($steps as $step): ?>
                <div class="step-item text-success"><?php echo $step; ?> <i class="bi bi-check-circle-fill"></i></div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-warning">No ticket found for your account.</div>
    <?php endif; ?>
</div>
</body>
</html>
