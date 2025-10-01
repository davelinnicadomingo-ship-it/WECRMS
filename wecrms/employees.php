
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
                    <li class="nav-item <?= $current_page === 'dashboard' ? '' : 'active' ?>">
                        <a href="dashboard.php">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $current_page === 'employees' ? 'active' : 'active' ?>">
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
                    <h1>Employee</h1>
                    <p class="page-subtitle">View and manage employee</p>
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

            <!-- Employee Management Section -->
            <div class="content-section">
                <div class="section-header">
                    <div>
                        <h2 class="section-title">Employee Management</h2>
                        <p style="color: #6b7280; font-size: 14px; margin-top: 4px;">View and manage employee information</p>
                    </div>
                    <div class="section-actions">
                        <button class="btn btn-primary" onclick="addEmployee()">
                            <i class="fas fa-plus"></i>
                            Add Employee
                        </button>
                    </div>
                </div>
                
                <div class="filters-row">
                    <input type="text" class="search-input" placeholder="Search Employees...">
                    <select class="filter-select">
                        <option>All Roles</option>
                        <option>Graphic Designer</option>
                        <option>Front End Dev</option>
                        <option>Back End Dev</option>
                        <option>UI/UX Designer</option>
                        <option>Project Manager</option>
                    </select>
                    <div style="margin-left: auto; padding: 8px 16px; background: #e0f2fe; border-radius: 8px; font-size: 14px; color: #0369a1;">
                        Total Employees: <strong>5 persons</strong>
                    </div>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Joining Date</th>
                            <th>Contract Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="employee-row" data-status="active">
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar" style="width: 40px; height: 40px; border-radius: 50%; background: #3b82f6; display: flex; align-items: center; justify-content: center; color: white; font-weight: 500;">A</div>
                                    <div class="employee-details">
                                        <h4>Alek Almeñe</h4>
                                        <div class="employee-email">alekalmerene@gmail.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-badge" style="background: #e0f2fe; color: #0369a1;">Graphic Designer</span></td>
                            <td>Feb 23, 2025</td>
                            <td><span class="status-badge" style="background: #dcfce7; color: #166534;">full-time</span></td>
                            <td><span class="status-badge status-active">ACTIVE</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn" data-action="view" data-id="1" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn" data-action="edit" data-id="1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn" data-action="delete" data-id="1" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="employee-row" data-status="active">
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar" style="width: 40px; height: 40px; border-radius: 50%; background: #10b981; display: flex; align-items: center; justify-content: center; color: white; font-weight: 500;">R</div>
                                    <div class="employee-details">
                                        <h4>Raven Gepulani</h4>
                                        <div class="employee-email">ravengepulani@gmail.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-badge" style="background: #e0f2fe; color: #0369a1;">Front End Dev</span></td>
                            <td>Jan 22, 2025</td>
                            <td><span class="status-badge" style="background: #dcfce7; color: #166534;">full-time</span></td>
                            <td><span class="status-badge status-active">ACTIVE</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn" data-action="view" data-id="2" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn" data-action="edit" data-id="2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn" data-action="delete" data-id="2" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="employee-row" data-status="active">
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar" style="width: 40px; height: 40px; border-radius: 50%; background: #8b5cf6; display: flex; align-items: center; justify-content: center; color: white; font-weight: 500;">T</div>
                                    <div class="employee-details">
                                        <h4>Troy Basangan</h4>
                                        <div class="employee-email">troybasangan@gmail.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-badge" style="background: #fee2e2; color: #991b1b;">Back End Dev</span></td>
                            <td>Jan 22, 2025</td>
                            <td><span class="status-badge" style="background: #dcfce7; color: #166534;">full-time</span></td>
                            <td><span class="status-badge status-active">ACTIVE</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn" data-action="view" data-id="3" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn" data-action="edit" data-id="3" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn" data-action="delete" data-id="3" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="employee-row" data-status="active">
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar" style="width: 40px; height: 40px; border-radius: 50%; background: #f59e0b; display: flex; align-items: center; justify-content: center; color: white; font-weight: 500;">G</div>
                                    <div class="employee-details">
                                        <h4>Gerick Pador</h4>
                                        <div class="employee-email">gerickpador@gmail.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-badge" style="background: #fef3c7; color: #92400e;">UI/UX Designer</span></td>
                            <td>Feb 22, 2025</td>
                            <td><span class="status-badge" style="background: #fef3c7; color: #92400e;">part-time</span></td>
                            <td><span class="status-badge status-active">ACTIVE</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn" data-action="view" data-id="4" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn" data-action="edit" data-id="4" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn" data-action="delete" data-id="4" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="employee-row" data-status="active">
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar" style="width: 40px; height: 40px; border-radius: 50%; background: #ef4444; display: flex; align-items: center; justify-content: center; color: white; font-weight: 500;">J</div>
                                    <div class="employee-details">
                                        <h4>Jackelyn Omena</h4>
                                        <div class="employee-email">jackelynomena@gmail.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-badge" style="background: #dcfce7; color: #166534;">Project Manager</span></td>
                            <td>Jan 12, 2025</td>
                            <td><span class="status-badge" style="background: #dcfce7; color: #166534;">full-time</span></td>
                            <td><span class="status-badge status-active">ACTIVE</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn" data-action="view" data-id="5" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn" data-action="edit" data-id="5" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn" data-action="delete" data-id="5" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
            </div>
    <script src="script.js"></script>
</body>
</html>