<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

requireLogin();

$db = new Database();
$conn = $db->connect();

$user = getUserData($conn, $_SESSION['user_id']);

if ($user['role'] !== 'hr_admin') {
    header('Location: dashboard.php');
    exit();
}

$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone_number'] ?? '';
        
        $stmt = $conn->prepare("UPDATE users SET email = :email, phone_number = :phone WHERE id = :id");
        $stmt->execute(['email' => $email, 'phone' => $phone, 'id' => $_SESSION['user_id']]);
        $success = 'Profile updated successfully!';
        $user = getUserData($conn, $_SESSION['user_id']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - HR System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/hr_sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1>HR SETTINGS</h1>
            <div class="user-info">
                <span>Welcome, <?php echo htmlspecialchars($user['full_name']); ?></span>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
        
        <div class="settings-container">
            <h2>HR Administrator Settings</h2>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="settings-section">
                <h3>Profile Information</h3>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Employee ID</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['employee_id']); ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" value="<?php echo htmlspecialchars($user['phone_number'] ?? ''); ?>">
                    </div>
                    
                    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
            
            <div class="settings-section">
                <h3>Notification Settings</h3>
                <p>Configure email and SMS notification preferences for HR staff.</p>
                <div class="form-group">
                    <label>
                        <input type="checkbox" checked> Receive email notifications for new tickets
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" checked> Receive email notifications for urgent tickets
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox"> Receive SMS notifications for high priority tickets
                    </label>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
