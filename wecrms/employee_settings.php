<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "employee_attendance");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

// ✅ Fetch employee info
$stmt = $conn->prepare("SELECT email, phone, address, nationality FROM employees WHERE name = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();


// ✅ Update field
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_field'])) {
    $field = $_POST['update_field'];
    $value = $_POST['new_value'];

    $allowed = ['email','password','phone','address','nationality'];
    if (in_array($field, $allowed)) {
        $sql = "UPDATE employees SET $field = ? WHERE name = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ss", $value, $username);
        $stmt->execute();
        $stmt->close();

        header("Location: employee_settings.php");
        exit();
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Settings</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
<style>
    .settings-section { background:#fff; border-radius:10px; padding:20px 25px; box-shadow:0 2px 6px rgba(0,0,0,0.08); margin-bottom:20px; }
    .settings-item { display:flex; justify-content:space-between; align-items: center; padding:15px 0; border-bottom:1px solid #eee; }
    .settings-item:last-child{border-bottom:none;}
    .settings-label { font-weight:600; }
    .settings-desc { color:#777; font-size:14px; }
    .settings-value { font-size:14px; margin-bottom:3px; }
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
                <h6 class="admin-name"><?php echo $_SESSION['username'] ?></h6>
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
            <li class="nav-item"><a class="nav-link" href="employee_chatbot.php"><i class="bi bi-robot"></i> Chatbot</a></li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-gear"></i> Settings</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>
</div>

<!-- Content -->
<div class="main-content">
    <header class="top-header d-flex align-items-center">
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
                    <li><a class="dropdown-item" href="employee_settings.php">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="login.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container mt-4" style="margin-left:260px; max-width:850px;">
        <h3 class="mb-4 fw-bold">Settings</h3>

    <div class="settings-section">
    <div class="settings-item">
        <div>
            <div class="settings-label">Password</div>
            <div class="settings-desc">Set a password to protect your account</div>
        </div>
        <div class="settings-value">••••••••••</div>
        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-field="password">Edit</button>
    </div>
 
    <div class="settings-section">
    <div class="setting-item">
                    <div>
                        <div class="setting-label">Two-Step Verification</div>
                        <div class="setting-desc">Extra security using verification code
                        <div class="form-check form-switch d-inline-block me-1"> <input class="form-check-input" type="checkbox" id="twoStepSwitch">
                    </div>

    <div class="settings-section">
    <div class="settings-item">
        <div>
            <div class="settings-label">Email</div>
             <div class="settings-desc">Change your email address</div>
            </div>
            <div class="settings-value"><?php echo htmlspecialchars($user['email']); ?></div>
             <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-field="email">Edit</button>
        </div>
    </div>
        
        <div class="settings-section">
            <div class="settings-item">
                <div>
                    <div class="settings-label">Phone Number</div>
                    <div class="settings-desc">Change your phone number</div>
                </div>
                <div class="settings-value"><?php echo htmlspecialchars($user['phone']); ?></div>
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-field="phone">Edit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="update_field" id="updateField">
          <div class="mb-3">
            <label class="form-label">New Value</label>
            <input type="text" class="form-control" name="new_value" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const field = button.getAttribute('data-field');
    document.getElementById('updateField').value = field;
});
</script>
</body>
</html>
