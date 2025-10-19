<div class="sidebar">
    <div class="sidebar-header">
        <h2>Trusting Social AI Philippines</h2>
    </div>
    
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <span class="nav-icon" class="bi bi-box-arrow-right me-2"></span> Home
        </a>
        <a href="profile.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
            <span class="nav-icon"></span> My Profile
        </a>
        <a href="tickets.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'tickets.php' ? 'active' : ''; ?>">
            <span class="nav-icon"></span> Tickets
        </a>
        <a href="javascript:void(0)" onclick="document.getElementById('chatbot-toggle').click()" class="nav-item">
            <span class="nav-icon"></span> Chat with Bot
        </a>
        <a href="status_update.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'status_update.php' ? 'active' : ''; ?>">
            <span class="nav-icon"></span> Status Update
        </a>
    </nav>
    
    <div class="sidebar-footer">
        <a href="settings.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
            <span class="nav-icon"></span> Settings
        </a>
        <a href="logout.php" class="nav-item">
            <span class="nav-icon"></span> Logout
        </a>
    </div>
</div>
