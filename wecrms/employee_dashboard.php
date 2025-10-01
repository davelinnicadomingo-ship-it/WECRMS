<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header('Location: login.php');
    exit();
}

include 'db_connect2.php'; 

if (!isset($_SESSION['user_id'])) {
    die("Error: user_id not found in session. Please log in again.");
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM employees WHERE id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) { die("SQL error: " . $conn->error); }
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$stmt->close();


if (!$employee) { die("No employee profile found for this user."); }

// ✅ Update data if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $status = $_POST['status'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $nationality = $_POST['nationality'];

    $update = "UPDATE employees 
               SET name=?, position=?, department=?, status=?, phone=?, address=?, nationality=? 
               WHERE email=?";
    $stmt = $conn->prepare($update);
    if (!$stmt) { die("SQL error: " . $conn->error); }

    $stmt->bind_param("ssssssss", 
        $name, $position, $department, $status, $phone, $address, $nationality, $employee['email']
    );
    $stmt->execute();
    $stmt->close();

    $_SESSION['username'] = $name;
    header("Location: employee_profile.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px 40px;
        }
        .top-header {
            background: #fff;
            border-radius: 12px;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dashboard-card {
            background: #fff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .shift-box {
            background: linear-gradient(135deg,#5f4ef7,#8b67f8);
            color: #fff;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
        }
        .status-circle {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: #eee;
            display: flex; justify-content: center; align-items: center;
            font-weight: bold;
            margin: auto;
        }
        .chat-bubble {
            background: #f1f1f7;
            border-radius: 12px;
            padding: 10px 15px;
            margin-bottom: 10px;
        }
        .calendar-box {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
        }
        .task-item {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 8px;
            color: #fff;
        }
        .task-blue { background: #4c6ef5; }
        .task-green { background: #2f9e44; }
        .task-orange { background: #f76707; }
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
                <h6 class="admin-name"><?php echo htmlspecialchars($employee['name']); ?></h6>
            </div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link active" href="employee_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="employee_profile.php"><i class="bi bi-person"></i> Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="employee_attendance.php"><i class="bi bi-calendar-check"></i> Attendance</a></li>
            <li class="nav-item"><a class="nav-link" href="employee_status.php"><i class="bi bi-graph-up"></i> Status Update</a></li>
            <li class="nav-item"><a class="nav-link" href="new_ticket.php"><i class="bi bi-ticket"></i> Tickets</a></li>
            <li class="nav-item"><a class="nav-link" href="employee_chatbot.php"><i class="bi bi-robot"></i> Chatbot</a></li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="employee_settings.php"><i class="bi bi-gear"></i> Settings</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>
</div>

<!-- Main -->
<div class="main-content">
    <!-- Top Header -->
    <div class="top-header mb-4">
        <h4 class="m-0">Hello <strong><?php echo htmlspecialchars($employee['name']); ?></strong>, Good Morning!</h4>
        <div class="d-flex align-items-center">
            <button class="btn btn-link d-lg-none" id="sidebarToggle"><i class="bi bi-list"></i></button>
            <div class="header-actions ms-auto d-flex align-items-center">
                <button class="btn btn-link me-3"><i class="bi bi-bell"></i></button>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <img src="images/lunod.jpg" alt="Employee" class="rounded-circle me-2" width="32" height="32">
                        <?php echo $_SESSION['username']; ?>
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

    <!-- Dashboard Content -->
    <div class="row g-4">

        <!-- Shift Duration (Real-time Clock) -->
        <div class="col-lg-3">
            <div class="shift-box">
                <h1 id="clock" class="display-5">--:--:--</h1>
                <p class="mb-2">Shift Duration: 06h 18min</p>
                <button class="btn btn-light btn-sm">Check Out</button>
            </div>
        </div>

        <!-- Previous Chat -->
        <div class="col-lg-5">
            <div class="dashboard-card">
                <h5>Previous chat with AI</h5>
                <div class="chat-bubble"><strong>AI:</strong> Please let me know if I can assist you.</div>
                <div class="chat-bubble"><strong>User:</strong> Request a leave.</div>
                <div class="chat-bubble"><strong>AI:</strong> Okay.</div>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="dashboard-card text-center">
                <div class="rounded-circle mx-auto mb-3" style="background:linear-gradient(135deg,#4c6ef5,#9c6ef5);width:80px;height:80px;display:flex;justify-content:center;align-items:center;color:#fff;font-weight:bold;font-size:24px;">AA</div>
                <h5><?php echo $_SESSION['username']; ?></h5>
                <p class="text-muted small mb-1"><?php echo htmlspecialchars($employee['role']); ?> </p>
                <?php echo $_SESSION['email']; ?> 
                <p class="text-muted small">Joined: <?php echo date("F j, Y", strtotime($employee['datehired'])); ?></p>
            </div>
        </div>

        <!-- Status Report -->
        <div class="col-lg-4">
            <div class="dashboard-card text-center">
                <h5>Status Report</h5>
                <div class="row">
                    <div class="col">
                        <div class="status-circle">70%</div>
                        <p class="mt-2 small">AI Conversation</p>
                    </div>
                    <div class="col">
                        <div class="status-circle">20%</div>
                        <p class="mt-2 small">Approval</p>
                    </div>
                    <div class="col">
                        <div class="status-circle">50%</div>
                        <p class="mt-2 small">Request</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div class="col-lg-4">
            <div class="calendar-box">
                <h5>Calendar</h5>
                <input type="month" class="form-control mb-2">
                <div class="small text-muted">Use arrows to navigate months</div>
            </div>
        </div>

        <!-- Tasks -->
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="task-item task-blue">10 Days</div>
                <div class="task-item task-green">1 Completed Task</div>
                <div class="task-item task-orange">3 In Progress</div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Real-time Clock
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        document.getElementById('clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
</body>
</html>
