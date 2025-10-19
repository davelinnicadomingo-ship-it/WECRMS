<?php
session_start();

/**
 * ✅ Check if the user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['employee_id']);
}

/**
 * ✅ Redirect user to login if not logged in
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

/**
 * ✅ Fetch employee data by ID
 */
function getEmployeeData($conn, $employee_id) {
    $stmt = $conn->prepare("SELECT * FROM employees WHERE employee_id = :employee_id");
    $stmt->execute(['employee_id' => $employee_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * ✅ Login user (by employee_id or email)
 */
function login($conn, $employee_id_or_email, $password) {
    $stmt = $conn->prepare("
        SELECT * FROM employees 
        WHERE employee_id = :input OR email = :input
        LIMIT 1
    ");
    $stmt->execute(['input' => $employee_id_or_email]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($employee) {
        // Allow both hashed and plain-text passwords (for admin/demo)
        if (password_verify($password, $employee['password']) || $password === $employee['password']) {
            $_SESSION['user_id'] = $employee['id'];
            $_SESSION['employee_id'] = $employee['employee_id'];
            $_SESSION['full_name'] = $employee['full_name'];
            $_SESSION['role'] = $employee['role'];
            $_SESSION['department'] = $employee['department'];
            return true;
        }
    }

    return false;
}

/**
 * ✅ Register new employee
 */
function register($conn, $employee_id, $full_name, $email, $department, $password, $role = 'employee') {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("
            INSERT INTO employees (employee_id, full_name, email, department, password, role)
            VALUES (:employee_id, :full_name, :email, :department, :password, :role)
        ");
        $stmt->execute([
            'employee_id' => $employee_id,
            'full_name'   => $full_name,
            'email'       => $email,
            'department'  => $department,
            'password'    => $password_hash,
            'role'        => $role
        ]);
        return true;
    } catch (PDOException $e) {
        // Handle duplicate employee_id or email
        if ($e->getCode() == 23000) {
            echo "<p style='color:red;'>❌ Employee ID or Email already exists.</p>";
        } else {
            echo "<p style='color:red;'>❌ Registration Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        return false;
    }
}

/**
 * ✅ Logout and destroy session
 */
function logout() {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
