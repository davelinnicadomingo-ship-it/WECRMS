
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
                    <li class="nav-item <?= $current_page === 'tickets' ? 'active' : 'active' ?>">
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
                    <h1>Tickets Management</h1>
                    <p class="page-subtitle">Manage employee concerns and request with priority tracking</p>
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
                    <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3>4</h3>
                        <div class="stat-label">Total Tickets</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div class="stat-content">
                        <h3>1</h3>
                        <div class="stat-label">Open</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3>1</h3>
                        <div class="stat-label">In Progress</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon attendance">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3>1</h3>
                        <div class="stat-label">Completed</div>
                    </div>
                </div>
            </div>

            <!-- Tickets Management -->
            <div class="content-section">
                <div class="tab-nav">
                    <button class="tab-btn active" data-tab="overview">Overview</button>
                    <button class="tab-btn" data-tab="tickets">Tickets</button>
                    <button class="tab-btn" data-tab="analytics">Analytics</button>
                    <button class="tab-btn" data-tab="trends">Trends</button>
                </div>
                
                <div id="overview" class="tab-content active">
                    <div class="filters-row">
                        <input type="text" class="search-input" placeholder="Search Tickets...">
                        <select class="filter-select">
                            <option>All Status</option>
                            <option>Open</option>
                            <option>In Progress</option>
                            <option>Completed</option>
                            <option>On Hold</option>
                        </select>
                        <select class="filter-select">
                            <option>All Priority</option>
                            <option>High</option>
                            <option>Medium</option>
                            <option>Low</option>
                        </select>
                        <select class="filter-select">
                            <option>All Categories</option>
                            <option>Access Control</option>
                            <option>Technical Support</option>
                            <option>HR Request</option>
                            <option>Equipment</option>
                        </select>
                    </div>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Ticket ID</th>
                                <th>Requester</th>
                                <th>Subject</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>#1</strong></td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #3b82f6; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">A</div>
                                        <div>
                                            <div style="font-weight: 500;">Alek Almeñe</div>
                                            <div style="font-size: 12px; color: #6b7280;">alekalmerene@gmail.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div style="font-weight: 500;">Lost ID or access card</div>
                                        <div style="font-size: 12px; color: #6b7280;">Need replacement access card for office entry</div>
                                    </div>
                                </td>
                                <td><span class="role-badge" style="background: #e0f2fe; color: #0369a1;">Access Control</span></td>
                                <td><span class="status-badge" style="background: #fee2e2; color: #991b1b;">high</span></td>
                                <td><span class="status-badge" style="background: #dcfce7; color: #166534;">open</span></td>
                                <td>01/03/25</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn" title="View"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>#2</strong></td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #10b981; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">R</div>
                                        <div>
                                            <div style="font-weight: 500;">Raven Gepulani</div>
                                            <div style="font-size: 12px; color: #6b7280;">ravengepulani@gmail.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div style="font-weight: 500;">Lost ID or access card</div>
                                        <div style="font-size: 12px; color: #6b7280;">Need replacement access card for office entry</div>
                                    </div>
                                </td>
                                <td><span class="role-badge" style="background: #f97316; color: white;">Technical Support</span></td>
                                <td><span class="status-badge" style="background: #fef3c7; color: #92400e;">medium</span></td>
                                <td><span class="status-badge" style="background: #fef3c7; color: #92400e;">in progress</span></td>
                                <td>02/04/25</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn" title="View"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>#3</strong></td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #8b5cf6; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">T</div>
                                        <div>
                                            <div style="font-weight: 500;">Troy Basangan</div>
                                            <div style="font-size: 12px; color: #6b7280;">troybasangan@gmail.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div style="font-weight: 500;">Lost ID or access card</div>
                                        <div style="font-size: 12px; color: #6b7280;">Need replacement access card for office entry</div>
                                    </div>
                                </td>
                                <td><span class="role-badge" style="background: #06b6d4; color: white;">HR Request</span></td>
                                <td><span class="status-badge" style="background: #fee2e2; color: #991b1b;">high</span></td>
                                <td><span class="status-badge" style="background: #f97316; color: white;">on hold</span></td>
                                <td>05/12/25</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn" title="View"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>#4</strong></td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #f59e0b; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">G</div>
                                        <div>
                                            <div style="font-weight: 500;">Gerick Pador</div>
                                            <div style="font-size: 12px; color: #6b7280;">gerickpador@gmail.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div style="font-weight: 500;">Lost ID or access card</div>
                                        <div style="font-size: 12px; color: #6b7280;">Need replacement access card for office entry</div>
                                    </div>
                                </td>
                                <td><span class="role-badge" style="background: #8b5cf6; color: white;">Equipment</span></td>
                                <td><span class="status-badge" style="background: #fef3c7; color: #92400e;">medium</span></td>
                                <td><span class="status-badge" style="background: #3b82f6; color: white;">completed</span></td>
                                <td>02/22/25</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn" title="View"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div id="tickets" class="tab-content" style="display: none;">
                    <div style="padding: 24px; text-align: center; color: #6b7280;">
                        <p>Detailed tickets view would be implemented here</p>
                    </div>
                </div>
                
                <div id="analytics" class="tab-content" style="display: none;">
                    <div style="padding: 24px;">
                        <h3 style="margin-bottom: 24px;">Request by Category</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                            <div style="padding: 16px; background: #f9fafb; border-radius: 8px;">
                                <div style="color: #6b7280; margin-bottom: 8px;">Access</div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="height: 8px; background: #3b82f6; border-radius: 4px; flex: 1;"></div>
                                    <span style="font-weight: 500;">1</span>
                                </div>
                            </div>
                            <div style="padding: 16px; background: #f9fafb; border-radius: 8px;">
                                <div style="color: #6b7280; margin-bottom: 8px;">Technical</div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="height: 8px; background: #3b82f6; border-radius: 4px; flex: 1;"></div>
                                    <span style="font-weight: 500;">1</span>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 32px; text-align: center;">
                            <h3 style="font-size: 32px; color: #3b82f6; margin-bottom: 8px;">2.4 days</h3>
                            <p style="color: #6b7280;">Average Resolution Time</p>
                        </div>
                    </div>
                </div>
                
                <div id="trends" class="tab-content" style="display: none;">
                    <div style="padding: 24px;">
                        <h3 style="margin-bottom: 24px;">Tickets Trends & Insights</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 32px;">
                            <div style="text-align: center; padding: 24px; background: #f9fafb; border-radius: 12px;">
                                <div style="font-size: 24px; font-weight: 600; color: #3b82f6; margin-bottom: 8px;">+15%</div>
                                <div style="color: #6b7280;">This month vs last</div>
                            </div>
                            <div style="text-align: center; padding: 24px; background: #f9fafb; border-radius: 12px;">
                                <div style="font-size: 24px; font-weight: 600; color: #10b981; margin-bottom: 8px;">89%</div>
                                <div style="color: #6b7280;">Resolution rate</div>
                            </div>
                            <div style="text-align: center; padding: 24px; background: #f9fafb; border-radius: 12px;">
                                <div style="font-size: 24px; font-weight: 600; color: #f59e0b; margin-bottom: 8px;">4.2/5</div>
                                <div style="color: #6b7280;">Employee satisfaction</div>
                            </div>
                        </div>
                        <h4 style="margin-bottom: 16px;">Common Issues & Recommendations</h4>
                        <div style="background: #f9fafb; padding: 16px; border-radius: 8px; margin-bottom: 16px;">
                            <h5 style="margin-bottom: 8px;">Access Card Issues</h5>
                            <p style="color: #6b7280; font-size: 14px;">Frequent requests for replacement cards. Consider improving card durability.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
            </div>
    <script src="script.js"></script>
</body>
</html>