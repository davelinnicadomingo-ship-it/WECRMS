<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header("Location: login.php");
    exit();
}

include 'db_connect2.php'; // ✅ attendance DB connection

// ✅ Get logged-in user info
$user_email = $_SESSION['email'];

// Find employee ID from employees table
$query = "SELECT id, name FROM employees WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

if (!$employee) {
    die("⚠ Employee record not found in attendance DB.");
}

$employee_id = $employee['id'];
$employee_name = $employee['name'];

// ✅ Handle attendance submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $today = date('Y-m-d');

    // Check if already marked today
    $check = $conn->prepare("SELECT * FROM attendance WHERE employee_id = ? AND date = ?");
    $check->bind_param("is", $employee_id, $today);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        $message = "⚠ You already marked your attendance today.";
    } else {
        $insert = $conn->prepare("INSERT INTO attendance (employee_id, date, status) VALUES (?, ?, ?)");
        $insert->bind_param("iss", $employee_id, $today, $status);
        if ($insert->execute()) {
            $message = "✅ Attendance marked successfully!";
        } else {
            $message = "❌ Error: " . $conn->error;
        }
    }
}

// ✅ Fetch attendance history
$historyQuery = $conn->prepare("SELECT date, status FROM attendance WHERE employee_id = ? ORDER BY date DESC");
$historyQuery->bind_param("i", $employee_id);
$historyQuery->execute();
$historyResult = $historyQuery->get_result();
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
        create-new-ticket {
width: 115px;
position: relative;
font-size: 11px;
line-height: 24px;
display: inline-block;
font-family: Inter;
color: #fff;
white-space: pre-wrap;
text-align: left;
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
                <li class="nav-item"><a class="nav-link active" href="employee_attendance.php"><i class="bi bi-calendar-check"></i> Attendance</a></li>
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

    <!-- Profile Content -->
     <div class="main-content">
        <header class="top-header d-flex align-items-center">
            <button class="btn btn-link d-lg-none" id="sidebarToggle"><i class="bi bi-list"></i></button>
            <div class="header-actions ms-auto d-flex align-items-center">
                <button class="btn btn-link me-3"><i class="bi bi-bell"></i></button>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <img src="lunod.jpg" alt="Employee" class="rounded-circle me-2" width="32" height="32">
                        <?php echo $_SESSION['username']; ?> <!-- ✅ -->
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="employee_profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="login.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>
    <div class="container mt-4" style="margin-left:260px; max-width:850px;">
        <div class="card shadow-sm p-4">
            <h5 class="text-muted">Attendance Portal</h5>

            <?php if ($message): ?>
                <div class="alert alert-info mt-3"><?php echo $message; ?></div>
            <?php endif; ?>

            <!-- Attendance Form -->
            <form method="POST" class="mt-3">
                <label for="status" class="form-label">Mark Attendance</label>
                <select name="status" class="form-select" required>
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                    <option value="leave">Leave</option>
                </select>
                <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
            </form>
        </div>

        <!-- Attendance History -->
        <div class="card shadow-sm p-5 mt-5">
            <h4 class="mb-3">My Attendance History</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $historyResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                            <td>
                                <?php if ($row['status'] === 'present'): ?>
                                    <span class="badge bg-success">Present</span>
                                <?php elseif ($row['status'] === 'absent'): ?>
                                    <span class="badge bg-danger">Absent</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Leave</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
