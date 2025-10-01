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
    <div class="app-container"><?php $current_page = $_GET['page'] ?? 'dashboard'; ?>
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
                    <li class="nav-item <?= $current_page === 'employees' ? 'active' : '' ?>">
                        <a href="employees.php">
                            <i class="fas fa-users"></i>
                            <span>Employee</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_page === 'tickets' ? 'active' : '' ?>">
                        <a href="tickets.php">
                            <i class="fas fa-ticket-alt"></i>
                            <span>Tickets</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_page === 'progress' ? 'active' : '' ?>">
                        <a href="progress.php">
                            <i class="fas fa-chart-line"></i>
                            <span>Progress Tracking</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_page === 'notifications' ? 'active' : '' ?>">
                        <a href="notifications.php">
                            <i class="fas fa-bell"></i>
                            <span>Notifications</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <a href="settings.php" class="settings-link <?= $current_page === 'settings' ? 'active' : 'active' ?>">
                    <i class="fas fa-cog"></i>
                </a>
                <a href="login.php" class="logout-link">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
            </aside>
                <main class="main-content">
            <div class="page-header">
                <div class="page-title">
                    <h1>Settings</h1>
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

            <!-- Admin Settings -->
            <div class="settings-section">
                <div class="settings-header">
                    <div class="settings-title">Admin</div>
                    <div class="settings-description">Manage your details and personal preferences here.</div>
                </div>
            </div>

            <!-- Basics Section -->
            <div class="settings-section">
                <div class="settings-header">
                    <div class="settings-title">Basics</div>
                </div>
                <div class="settings-content">
                    <div class="setting-item">
                        <div class="setting-info">
                            <h4>Password</h4>
                            <p>Set a password to protect your account</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="setting-value">••••••••••••••••</div>
                            <span style="background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Very Secure</span>
                            <button class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;">Edit</button>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h4>Two-Step verification</h4>
                            <p>We recommend requiring a verification code in addition to your password</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="toggle-switch"></div>
                            <span style="color: #6b7280; font-size: 14px;">Two-Step verification</span>
                            <button class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;">Edit</button>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h4>Email</h4>
                            <p>Change your email address</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="setting-value">hr@example.com</div>
                            <button class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;">Edit</button>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h4>Phone Number</h4>
                            <p>Change your Phone Number</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="setting-value">(+63) xxx xxx xxxx</div>
                            <button class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
            </div>
    <script src="script.js"></script>
</body>
</html>