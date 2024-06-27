<header>
<nav>
    <div class="logo-container">
        <div class="logo-nav">
            <img src="images/logo.png" alt="Grill Restaurant Logo" class="logo" onclick="window.location.href='index.php'">
        </div>
        <div class="links-nav">
            <a href="index.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="reservation.php">Reservation</a>
            <a href="contact.php">Contact</a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
                <a href="admin/admin.php">Admin</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

    </header>