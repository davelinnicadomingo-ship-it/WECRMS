
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
                    <li class="nav-item <?= $current_page === 'progress' ? 'active' : 'active' ?>">
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
                <a href="settings.php" class="settings-link <?= $current_page === 'settings' ? 'active' : '' ?>">
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
                    <h1>PROGRESS TRACKING</h1>
                    <p class="page-subtitle">You received 5 tickets from your employees this week.</p>
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

            <!-- Progress Overview -->
            <div style="background: #f0f4ff; padding: 16px 24px; border-radius: 8px; margin-bottom: 24px; color: #1e40af;">
                The data contained a received ticket report from the employee. This is the updated report for the month of <strong>May 2025</strong>.
            </div>

            <!-- Progress Items -->
            <div class="content-section">
                <div class="progress-item">
                    <div class="progress-header">
                        <div>
                            <div class="progress-title"># 234 - Alek Almeñe</div>
                            <div class="progress-status">Status: Completed</div>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill completed" style="width: 100%;"></div>
                    </div>
                </div>
                
                <div class="progress-item">
                    <div class="progress-header">
                        <div>
                            <div class="progress-title"># 234 - Raven Gepulani</div>
                            <div class="progress-status">Status: In progress</div>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill in-progress" style="width: 60%;"></div>
                    </div>
                </div>
                
                <div class="progress-item">
                    <div class="progress-header">
                        <div>
                            <div class="progress-title"># 234 - Gerick Pador</div>
                            <div class="progress-status">Status: Open</div>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill open" style="width: 15%;"></div>
                    </div>
                </div>
                
                <div class="progress-item">
                    <div class="progress-header">
                        <div>
                            <div class="progress-title"># 234 - Troy Basagna</div>
                            <div class="progress-status">Status: On Hold</div>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill on-hold" style="width: 45%;"></div>
                    </div>
                </div>
                
                <div class="progress-item">
                    <div class="progress-header">
                        <div>
                            <div class="progress-title"># 234 - Jackielyn Omena</div>
                            <div class="progress-status">Status: Completed</div>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill completed" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </main>
            </div>
    <script src="script.js"></script>
</body>
</html>