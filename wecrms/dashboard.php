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
                    <li class="nav-item <?= $current_page === 'dashboard' ? 'active' : '' ?>">
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
                    <h1>Dashboard</h1>
                    <p class="page-subtitle">Hello Admin, <strong>Good Morning</strong></p>
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
            

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon employees">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3>5/40</h3>
                        <div class="stat-label">Total Employees:</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon attendance">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3>100%</h3>
                        <div class="stat-label">Attendance Rate</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon leave">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3>0/40</h3>
                        <div class="stat-label">On Leave</div>
                    </div>
                </div>
            </div>

            <!-- Recent Tickets and Create Announcement -->
            <div style="display: grid; grid-template-columns: 1fr 400px; gap: 24px; align-items: start;">
                <!-- Recent Tickets -->
                <div class="content-section">
                    <div class="section-header">
                        <h2 class="section-title">Recent Tickets</h2>
                        <a href="?page=tickets" class="btn btn-outline">View All</a>
                    </div>
                    <div class="section-content">
                        <div class="ticket-item" style="padding: 16px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="font-weight: 500; color: #1f2937; margin-bottom: 4px;">#1 - Lost ID or access card</h4>
                                <p style="color: #6b7280; font-size: 14px;">Alek Almeñe</p>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <span class="status-badge" style="background: #dbeafe; color: #1e40af;">New</span>
                                <span class="status-badge" style="background: #dbeafe; color: #1e40af;">Access</span>
                            </div>
                        </div>
                        <div class="ticket-item" style="padding: 16px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="font-weight: 500; color: #1f2937; margin-bottom: 4px;">#2 - System Access Issue</h4>
                                <p style="color: #6b7280; font-size: 14px;">Raven Gepulani</p>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <span class="status-badge" style="background: #f3f4f6; color: #374151;">Technical</span>
                                <span class="status-badge" style="background: #fef3c7; color: #92400e;">In Progress</span>
                            </div>
                        </div>
                        <div class="ticket-item" style="padding: 16px 24px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="font-weight: 500; color: #1f2937; margin-bottom: 4px;">#3 - Leave Request</h4>
                                <p style="color: #6b7280; font-size: 14px;">Troy Basangan</p>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <span class="status-badge" style="background: #dbeafe; color: #1e40af;">New</span>
                                <span class="status-badge" style="background: #fee2e2; color: #991b1b;">on hold</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create Announcement -->
                <div class="content-section">
                    <div class="section-header">
                        <h2 class="section-title">Create announcement</h2>
                    </div>
                    <div style="padding: 24px;">
                        <form>
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-input" placeholder="Enter announcement title">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Message</label>
                                <textarea class="form-input form-textarea" placeholder="Enter your message here..." rows="4"></textarea>
                            </div>
                            <div style="display: flex; gap: 12px; margin-bottom: 16px;">
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; color: #6b7280;">
                                    <input type="checkbox"> Email Notification
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; color: #6b7280;">
                                    <input type="checkbox"> SMS Notification
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Send Announcement</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="?page=employees" class="quick-action-card">
                    <div class="quick-action-icon add-employee">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3 class="quick-action-title">Add Employee</h3>
                </a>
                <a href="#" class="quick-action-card">
                    <div class="quick-action-icon ai-assistant">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3 class="quick-action-title">AI Assistant</h3>
                </a>
                <a href="?page=progress" class="quick-action-card">
                    <div class="quick-action-icon view-progress">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3 class="quick-action-title">View Progress</h3>
                </a>
            </div>
        </main>
            </div>
    <script src="script.js"></script>
</body>
</html>