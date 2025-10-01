<?php
session_start();
include 'db_connect2.php'; // ✅ DB connection

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Fetch user from DB
    $query = "SELECT id, email, password, role FROM employees WHERE email = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Prepare failed (users): " . $conn->error); // ✅ Debug if query fails
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && $password === $user['password']) { 
        // ⚠️ In production: use password_hash/password_verify

        // Save session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['role']    = $user['role'];

        // Optional: Fetch employee name from employees table
        $empQuery = "SELECT name FROM employees WHERE email = ?";
        $empStmt = $conn->prepare($empQuery);

        if ($empStmt === false) {
            die("Prepare failed (employees): " . $conn->error); // ✅ Debug if query fails
        }

        $empStmt->bind_param("s", $user['email']);
        $empStmt->execute();
        $empResult = $empStmt->get_result();
        $emp = $empResult->fetch_assoc();
        $empStmt->close();

        $_SESSION['username'] = $emp ? $emp['name'] : $user['email'];

        // Redirect based on role
        if ($user['role'] === 'employee') {
            header("Location: employee_dashboard.php");
        } elseif ($user['role'] === 'hr') {
            header("Location: dashboard.php");
        } elseif ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        }
        exit();
    } else {
        $message = "Invalid email or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body, html { height: 100%; font-family: Arial, sans-serif; }

        video.bg-video {
            position: fixed;
            top: 0; left: 0;
            min-width: 100%; min-height: 100%;
            object-fit: cover;
            z-index: -1;
            filter: brightness(0.6);
        }

        .login-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.08);
            padding: 2rem;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            color: white;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }

        .login-box input[type="submit"] {
            background: #0d6efd;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .login-box input[type="submit"]:hover {
            background: #084298;
        }

        .message {
            color: #ffc107;
            font-size: 0.9rem;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Background video -->
<video autoplay muted loop class="bg-video">
    <source src="images/background.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="login-container">
    <form class="login-box" method="POST">
        <h2>Login</h2>
        <input type="email" name="email" placeholder="Email address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Log In">
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
    </form>
</div>
        
</body>
</html>
