<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

requireLogin();

$db = new Database();
$conn = $db->connect();

$user = getEmployeeData($conn, $_SESSION['employee_id']);
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone_number = $_POST['phone_number'] ?? '';
    $email = $_POST['email'] ?? '';
    
    try {
        $stmt = $conn->prepare("UPDATE users SET phone_number = :phone_number, email = :email WHERE id = :employee_id");
        $stmt->execute([
            'phone_number' => $phone_number,
            'email' => $email,
            'employee_id' => $_SESSION['employee_id']
        ]);
        $success = 'Settings updated successfully!';
        $user = getEmployeeData($conn, $_SESSION['employee_id']);
    } catch(PDOException $e) {
        $error = 'Failed to update settings.';
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
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1>SETTINGS</h1>
            <div class="user-info">
                <img src="assets/images/avatar.png" alt="Avatar" class="avatar">
                <span><?php echo htmlspecialchars($user['full_name']); ?></span>
            </div>
        </div>
        
        <div class="settings-container">
            <h2>Employee</h2>
            <p class="settings-subtitle">Manage your details and personal preferences here.</p>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="settings-section">
                <h3>Basics</h3>
                
                <div class="setting-item">
                    <div class="setting-label">
                        <strong>Password</strong>
                        <p>Set a password to protect your account</p>
                    </div>
                    <div class="setting-value">
                        <span>••••••••••••••••••••</span>
                        <span class="badge badge-success">Very Secure</span>
                        <button class="btn btn-secondary btn-sm">Edit</button>
                    </div>
                </div>
                
                <div class="setting-item">
                    <div class="setting-label">
                        <strong>Two-Step verification</strong>
                        <p>We recommend requiring a verification code in addition to your password</p>
                    </div>
                    <div class="setting-value">
                        <label class="toggle">
                            <input type="checkbox" name="two_step_verification" 
       <?php echo !empty($user['two_step_verification']) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <button class="btn btn-secondary btn-sm">Edit</button>
                    </div>
                </div>
                
                <form method="POST" action="">
                    <div class="setting-item">
                        <div class="setting-label">
                            <strong>Email</strong>
                            <p>Change your email address</p>
                        </div>
                        <div class="setting-value">
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control">
                            <button class="btn btn-secondary btn-sm">Edit</button>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-label">
                            <strong>Phone Number</strong>
                            <p>Change your Phone Number</p>
                        </div>
                        <div class="setting-value">
                            <input type="text" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number'] ?? ''); ?>" class="form-control" placeholder="(+63) XXX XXX XXXX">
                            <button class="btn btn-secondary btn-sm">Edit</button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
