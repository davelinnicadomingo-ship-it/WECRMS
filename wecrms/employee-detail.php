<?php
$employee_id = $_GET['id'] ?? '1';

// Sample employee data (in a real app, this would come from a database)
$employees = [
    '1' => [
        'name' => 'Alek Almeñe',
        'position' => 'Graphic Designer',
        'email' => 'alekalmerene@gmail.com',
        'phone' => '+63 912 345 678 9',
        'address' => '40 Victory Ave. Tatalon Quezon City',
        'date_applied' => '2 / 23/ 2025',
        'age' => '25 yrs',
        'gender' => 'Male',
        'avatar_color' => '#3b82f6'
    ],
    '2' => [
        'name' => 'Raven Gepulani',
        'position' => 'Front End Dev',
        'email' => 'ravengepulani@gmail.com',
        'phone' => '+63 912 345 678 9',
        'address' => '40 Victory Ave. Tatalon Quezon City',
        'date_applied' => '1 / 22/ 2025',
        'age' => '25 yrs',
        'gender' => 'Male',
        'avatar_color' => '#10b981'
    ],
    '3' => [
        'name' => 'Troy Basangan',
        'position' => 'Back End Dev',
        'email' => 'troybasangan@gmail.com',
        'phone' => '+63 912 345 678 9',
        'address' => '40 Victory Ave. Tatalon Quezon City',
        'date_applied' => '1 / 22/ 2025',
        'age' => '21 yrs',
        'gender' => 'Male',
        'avatar_color' => '#8b5cf6'
    ],
    '4' => [
        'name' => 'Gerick Pador',
        'position' => 'UI/UX Designer',
        'email' => 'gerickpador@gmail.com',
        'phone' => '+63 912 345 678 9',
        'address' => '40 Victory Ave. Tatalon Quezon City',
        'date_applied' => '2 / 22/ 2025',
        'age' => '20 yrs',
        'gender' => 'Male',
        'avatar_color' => '#f59e0b'
    ],
    '5' => [
        'name' => 'Jackelyn Omena',
        'position' => 'Project Manager',
        'email' => 'jackelynomena@gmail.com',
        'phone' => '+63 912 345 678 9',
        'address' => '40 Victory Ave. Tatalon Quezon City',
        'date_applied' => '1 / 12/ 2025',
        'age' => '25 yrs',
        'gender' => 'Male',
        'avatar_color' => '#ef4444'
    ]
];

$employee = $employees[$employee_id] ?? $employees['1'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trusting Social AI Philippines - Admin Dashboard</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app-container">
        <?php $current_page = $_GET['page'] ?? 'dashboard'; ?>
            <aside class="sidebar">
            <div class="sidebar-header">
                <div class="company-logo">
                    <div class="logo-circle">
                        <span>T</span>
                    </div>
                    <div class="company-info">
                        <h1>Trusting<br>Social AI<br>Philippines</h1>
                    </div>
                </div>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="admin-profile">
                <div class="admin-avatar">A</div>
                <span class="admin-label">Admin</span>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item <?= $current_page === 'dashboard' ? '' : '' ?>">
                        <a href="dashboard.php">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_page === 'employees' ? 'active' : 'active' ?>">
                        <a href="?page=employees">
                            <i class="fas fa-users"></i>
                            <span>Employee</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_page === 'tickets' ? 'active' : '' ?>">
                        <a href="?page=tickets">
                            <i class="fas fa-ticket-alt"></i>
                            <span>Tickets</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_page === 'progress' ? 'active' : '' ?>">
                        <a href="?page=progress">
                            <i class="fas fa-chart-line"></i>
                            <span>Progress Tracking</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_page === 'notifications' ? 'active' : '' ?>">
                        <a href="?page=notifications">
                            <i class="fas fa-bell"></i>
                            <span>Notifications</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <a href="?page=settings" class="settings-link <?= $current_page === 'settings' ? 'active' : '' ?>">
                    <i class="fas fa-cog"></i>
                </a>
                <a href="#" class="logout-link">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </aside>
        <main class="main-content">
            <div class="page-header">
                <div class="page-title">
                    <a href="?page=employees" style="color: #6b7280; text-decoration: none; display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                        <i class="fas fa-chevron-left"></i>
                        <span style="font-size: 24px; font-weight: 600;">Employee Details</span>
                    </a>
                </div>
                <div class="page-actions">
                    <div class="header-user">
                        <i class="fas fa-bell" style="color: #6b7280;"></i>
                        <div class="user-avatar">A</div>
                        <span>Admin</span>
                        <i class="fas fa-chevron-down" style="color: #6b7280; font-size: 12px;"></i>
                    </div>
                </div>
            </div>

            <!-- Employee Profile -->
            <div class="employee-profile">
                <div class="profile-header">
                    <div class="profile-avatar" style="width: 100px; height: 100px; border-radius: 50%; background: <?= $employee['avatar_color'] ?>; display: flex; align-items: center; justify-content: center; color: white; font-size: 36px; font-weight: 600;">
                        <?= substr($employee['name'], 0, 1) ?>
                    </div>
                    <div class="profile-info">
                        <h1><?= $employee['name'] ?></h1>
                        <div class="profile-meta">
                            <div class="meta-item">
                                <i class="fas fa-mars" style="margin-right: 4px;"></i>
                                <?= $employee['gender'] ?>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar" style="margin-right: 4px;"></i>
                                <?= $employee['age'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="profile-details">
                    <h3 style="margin-bottom: 20px; color: #6366f1; border-bottom: 2px solid #6366f1; padding-bottom: 8px; display: inline-block;">Basic Information</h3>
                    <div class="details-grid">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-user" style="margin-right: 8px;"></i>
                                Name
                            </div>
                            <div class="detail-value"><?= $employee['name'] ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-calendar" style="margin-right: 8px;"></i>
                                Date applied
                            </div>
                            <div class="detail-value"><?= $employee['date_applied'] ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-briefcase" style="margin-right: 8px;"></i>
                                Position
                            </div>
                            <div class="detail-value"><?= $employee['position'] ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-envelope" style="margin-right: 8px;"></i>
                                Email
                            </div>
                            <div class="detail-value"><?= $employee['email'] ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>
                                Address
                            </div>
                            <div class="detail-value"><?= $employee['address'] ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-phone" style="margin-right: 8px;"></i>
                                Phone number
                            </div>
                            <div class="detail-value"><?= $employee['phone'] ?></div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 32px;">
                        <div style="color: #6b7280; font-weight: 500; margin-bottom: 12px;"># Tags</div>
                        <div style="display: flex; gap: 8px;">
                            <span style="background: #dcfce7; color: #166534; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 500;">
                                <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block; margin-right: 8px;"></span>
                                <?= $employee['position'] ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
            </div>
    <script src="script.js"></script>
</body>
</html>