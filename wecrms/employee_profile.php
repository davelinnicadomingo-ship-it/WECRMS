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
                    <img src="images/lunod.jpg" alt="Photo" class="admin-avatar-img">
                    <h6 class="admin-name"><?php echo $_SESSION['username'] ?></h6> <!-- ✅ show username -->
                </div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="employee_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="employee_profile.php"><i class="bi bi-person"></i> Profile</a></li>
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
                        <li><a class="dropdown-item" href="employee_settings.php">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="login.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>
    <div class="container mt-4" style="margin-left:260px; max-width:850px;">
        <div class="row">
            <!-- Profile Info -->
            <div class="col-md-6">
                <div class="profile-card profile-header d-flex align-items-center">
                    <button class="ellipsis-btn" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Edit</a></li>
                    </ul>
                    <img src="alk.png" alt="Employee">
                    <div>
                        <h5><?php echo htmlspecialchars($employee['name']); ?></h5>
                        <p class="text-muted">Joined <?php echo date("F j, Y", strtotime($employee['datehired'])); ?></p>
                        <p><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($employee['phone']); ?></p>
                    </div>
                </div>

                <div class="profile-card">
                    <button class="ellipsis-btn" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Edit</a></li>
                    </ul>
                    <h6 class="info-label">Emails</h6>
                    <p class="info-value"><?php echo htmlspecialchars($employee['email']); ?></p>
                </div>

                <div class="profile-card">
                    <button class="ellipsis-btn" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Edit</a></li>
                    </ul>
                    <h6 class="info-label">Phone Number</h6>
                    <p class="info-value"><?php echo htmlspecialchars($employee['phone']); ?></p>
                </div>
            </div>

            <!-- Address & Options -->
            <div class="col-md-6">
                <div class="profile-card">
                    <button class="ellipsis-btn" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Edit</a></li>
                    </ul>
                    <h6 class="info-label">Address</h6>
                    <p class="info-value"><?php echo htmlspecialchars($employee['address']); ?></p>
                </div>

                <div class="profile-card">
                    <button class="ellipsis-btn" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Edit</a></li>
                    </ul>
                    <h6 class="info-label">Account Options</h6>
                    <p><strong>Language:</strong> English</p>
                    <p><strong>Time zone:</strong> (GMT+8) Philippines</p>
                    <p><strong>Nationality:</strong> <?php echo htmlspecialchars($employee['nationality']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
