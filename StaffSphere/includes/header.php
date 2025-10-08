<header class="main-header">
    <div class="header-container">
        <div class="logo">
            <h2>Employee Management System</h2>
        </div>
        <nav class="main-nav">
            <?php if (isHR()): ?>
                <a href="hr_dashboard.php" class="nav-link">Dashboard</a>
            <?php else: ?>
                <a href="index.php" class="nav-link">My Tickets</a>
                <a href="create_ticket.php" class="nav-link">Create Ticket</a>
            <?php endif; ?>
        </nav>
        <div class="user-menu">
            <span class="user-name">Welcome, <?php echo htmlspecialchars(getUserName()); ?></span>
            <a href="logout.php" class="btn btn-logout">Logout</a>
        </div>
    </div>
</header>
