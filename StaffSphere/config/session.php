<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['employee_id']);
}

function isHR() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'hr_admin';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

function requireHR() {
    requireLogin();
    if (!isHR()) {
        header('Location: index.php');
        exit();
    }
}

function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getEmployeeId() {
    return $_SESSION['employee_id'] ?? null;
}

function getUserName() {
    return $_SESSION['full_name'] ?? 'User';
}

function getUserRole() {
    return $_SESSION['role'] ?? 'employee';
}
