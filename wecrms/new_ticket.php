<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header("Location: login.php");
    exit();
}

include 'db_connect2.php'; // ✅ connect to your "user" database

// ✅ Get employee info
$user_email = $_SESSION['email'];
$query = "SELECT id, name FROM employees WHERE email = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("⚠ SQL Error (Employee Lookup): " . $conn->error);
}

$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

if (!$employee) {
    die("⚠ Employee record not found.");
}
$employee_id = $employee['id'];
$employee_name = $employee['name'];

$message = "";

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $status = "open"; // default status when creating

    $insert = $conn->prepare("INSERT INTO tickets (employee_id, title, description, status, priority, created_at) 
                              VALUES (?, ?, ?, ?, ?, NOW())");

    if (!$insert) {
        die("⚠ SQL Error (Insert Ticket): " . $conn->error);
    }

    $insert->bind_param("issss", $employee_id, $title, $description, $status, $priority);

    if ($insert->execute()) {
        $message = "✅ Ticket created successfully!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="brand-section">
                <h4 class="brand-title">Trusting<br>Social AI<br>Philippines</h4>
                <div class="admin-profile">
                    <img src="images/lunod.jpg" alt="Employee" class="admin-avatar-img">
                    <h6 class="admin-name"><?php echo $_SESSION['username']; ?></h6>
                </div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="employee_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="employee_profile.php"><i class="bi bi-person"></i> Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="employee_attendance.php"><i class="bi bi-calendar-check"></i> Attendance</a></li>
                <li class="nav-item"><a class="nav-link" href="employee_status.php"><i class="bi bi-graph-up"></i> Status Update</a></li>
                <li class="nav-item"><a class="nav-link active" href="new_ticket.php"><i class="bi bi-ticket"></i> Tickets</a></li>
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

    <!-- Main Content -->
     <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
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
                <li class="nav-item"><a class="nav-link" href="employee_status.php"><i class="bi bi-graph-up"></i> Status Update</a></li>
                <li class="nav-item"><a class="nav-link active" href="new_ticket.php"><i class="bi bi-ticket"></i> Tickets</a></li>
                <li class="nav-item"><a class="nav-link" href="employee_chatbot.php"><i class="bi bi-robot"></i> Chatbot</a></li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="employee_settings."><i class="bi bi-gear"></i> Settings</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
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
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="login.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>
    <div class="container mt-5" style="margin-left:260px; max-width:850px;">
        <div class="card shadow-sm p-4">
            <h2 class="mb-3">New Ticket</h2>
            <p class="text-muted">Hello, <strong><?php echo htmlspecialchars($employee_name); ?></strong> please fill out the form below.</p>

            <?php if ($message): ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Subject</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter subject" required>
                </div>

                <div class="mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select name="priority" class="form-select" required>
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Ticket Body</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Describe your issue here..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Submit Ticket</button>
            </form>
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
