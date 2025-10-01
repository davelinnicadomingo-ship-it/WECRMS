<?php
session_start();

// Basic routing system
$page = $_GET['page'] ?? 'dashboard';
$allowed_pages = ['dashboard', 'employees', 'tickets', 'progress', 'notifications', 'settings', 'employee-detail'];

if (!in_array($page, $allowed_pages)) {
    $page = 'dashboard';
}

// Include the main template
include 'header.php';
include 'sidebar.php';

// Include the requested page
switch($page) {
    case 'dashboard':
        include 'dashboard.php';
        break;
    case 'employees':
        include 'employees.php';
        break;
    case 'tickets':
        include 'tickets.php';
        break;
    case 'progress':
        include 'pages/progress.php';
        break;
    case 'notifications':
        include 'pages/notifications.php';
        break;
    case 'settings':
        include 'pages/settings.php';
        break;
    case 'employee-detail':
        include 'pages/employee-detail.php';
        break;
}

include 'includes/footer.php';
?>