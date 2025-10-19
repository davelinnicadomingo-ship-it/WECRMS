<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

requireLogin();

$db = new Database();
$conn = $db->connect();

$user = getEmployeeData($conn, $_SESSION['employee_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - HR System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1>MY PROFILE</h1>
            <div class="user-info">
                <img src="assets/images/avatar.png" alt="Avatar" class="avatar">
                <span><?php echo htmlspecialchars($user['full_name']); ?></span>
            </div>
        </div>
        
        <div class="profile-container">
            <div class="profile-left">
                <div class="profile-header">
                    <h2>Your profile</h2>
                    <span>Joined <?php echo date('n/j/y', strtotime($user['created_at'])); ?></span>
                </div>
                
                <div class="profile-avatar">
                    <img src="assets/images/avatar.png" alt="Profile" class="large-avatar">
                    <button class="btn btn-primary btn-sm">Edit</button>
                </div>
                
                <div class="profile-name">
                    <h3><?php echo htmlspecialchars($user['full_name']); ?></h3>
                    <p><?php echo htmlspecialchars($user['phone_number'] ?? '+63 9123456789'); ?></p>
                </div>
                
                <div class="profile-section">
                    <h4>Emails</h4>
                    <div class="email-item"><?php echo htmlspecialchars($user['email']); ?></div>
                    <button class="btn btn-link">See all email (2)</button>
                    <button class="btn btn-secondary btn-sm">Add Email</button>
                </div>
                
                <div class="profile-section">
                    <h4>Phone Number</h4>
                    <div class="phone-item"><?php echo htmlspecialchars($user['phone_number'] ?? '+63 912 345 678 9'); ?></div>
                    <button class="btn btn-link">See all phone # (2)</button>
                    <button class="btn btn-secondary btn-sm">Add Phone #</button>
                </div>
            </div>
            
            <div class="profile-right">
                <div class="address-section">
                    <h3>Address</h3>
                    <div class="address-item">
                        <p>40 Victory Ave. Tatalon Quezon City</p>
                    </div>
                    <div class="address-item">
                        <p>629 J Nepomuceno, Quiapo, Manila</p>
                    </div>
                </div>
                
                <div class="account-options">
                    <h3>Account Options</h3>
                    <div class="option-item">
                        <strong>Language</strong>
                        <p><?php echo htmlspecialchars($user['language'] ?? 'English'); ?></p>
                    </div>
                    <div class="option-item">
                        <strong>Time zone</strong>
                        <p><?php echo htmlspecialchars($user['timezone'] ?? 'GMT+8'); ?> Time in Philippines</p>
                    </div>
                    <div class="option-item">
                        <strong>Nationality</strong>
                        <p><?php echo htmlspecialchars($user['nationality'] ?? 'Filipino'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
