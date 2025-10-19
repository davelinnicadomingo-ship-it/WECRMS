<div class="sidebar">
    <div class="sidebar-header">
        <h2>Employee Management System</h2>
        <p class="sidebar-subtitle">HR Admin Panel</p>
    </div>
    
    <nav class="sidebar-nav">
        <a href="hr_dashboard.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'hr_dashboard.php' ? 'active' : 'active'; ?>">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="hr_employees.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'hr_employees.php' ? 'active' : ''; ?>">
            <span class="nav-icon">👥</span> Employee Monitoring
        </a>
        <a href="hr_ticket_detail.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'hr_ticket_detail.php' ? '' : 'active'; ?>">
            <span class="nav-icon">🎫</span> Tickets Management
        </a>
        <a href="hr_notifications.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'hr_notifications.php' ? 'active' : ''; ?>">
            <span class="nav-icon">🔔</span> Notifications
        </a>
        <a href="hr_settings.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'hr_settings.php' ? 'active' : ''; ?>">
            <span class="nav-icon">⚙️</span> Settings
        </a>
    </nav>
    
    <div class="sidebar-footer">
        <a href="logout.php" class="nav-item">
            <span class="nav-icon">🚪</span> Logout
        </a>
    </div>
</div>
