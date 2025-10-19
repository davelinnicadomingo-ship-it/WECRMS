<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

$db = new Database();
$conn = $db->connect();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (login($conn, $employee_id, $password)) {
        // ✅ Fetch the logged-in employee's data
        $employee = getEmployeeData($conn, $_SESSION['employee_id']);
        
        // ✅ Redirect based on role
        if ($employee && isset($employee['role']) && $employee['role'] === 'hr_admin') {
            header('Location: hr_dashboard.php');
        } else {
            header('Location: dashboard.php');
        }
        exit();
    } else {
        $error = 'Invalid Employee ID or Password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login - HR System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h2 class="auth-title">Employee Concern & Request System</h2>
            <h3 class="auth-subtitle">Login</h3>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="employee_id">Employee ID</label>
                    <input type="text" id="employee_id" name="employee_id" class="form-control" placeholder="employee03" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            
            <p class="auth-footer">
                Don't have an account? <a href="register.php">Register here</a>
            </p>
            
            <div class="demo-info">
                <strong>Demo Account:</strong><br>
                Employee ID: HR001 | Password: admin123
            </div>
        </div>
    </div>
</body>
</html>
