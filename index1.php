<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name']) && isset($_SESSION['is_admin'])) {
    header("Location: adminindex.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | Western Railway E-Ticket System</title>
    <link rel="icon" href="image/icon1.png" type="image/png">
    <link rel="stylesheet" href="css/modern-railway.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="auth-page-wrapper">

    <div class="auth-card">
        <div class="auth-header" style="background: linear-gradient(135deg, #0b2545 0%, #1e3a5f 100%); color:#ffffff;">
            <img src="image/icon3.png" alt="Indian Railways Emblem" class="auth-header-logo" style="filter: drop-shadow(0 0 8px rgba(255,255,255,0.3));">
            <h2 style="color:#ffffff;">WR Commercial Admin</h2>
            <p style="color:#94a3b8;">Suburban Operations & Ticketing Console</p>
        </div>

        <div class="auth-body">
            <!-- Mode Switcher -->
            <div class="trip-type-segmented" style="margin-bottom: 1.5rem;">
                <a href="index.php" class="trip-type-btn" style="text-decoration:none;"><i class="fas fa-user"></i> Passenger Login</a>
                <a href="index1.php" class="trip-type-btn active" style="text-decoration:none;"><i class="fas fa-shield-halved"></i> Admin Portal</a>
            </div>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert-box alert-danger">
                    <i class="fas fa-triangle-exclamation"></i>
                    <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                </div>
            <?php } ?>

            <form action="login1.php" method="POST">
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="uname"><i class="fas fa-id-badge"></i> Officer Username / Admin ID</label>
                    <input type="text" id="uname" name="uname" class="form-control" placeholder="Enter Admin ID" required autofocus>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="password"><i class="fas fa-key"></i> Security Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter security password" required>
                </div>

                <button type="submit" class="btn-primary" style="margin-bottom: 1rem; background: linear-gradient(135deg, #0b2545 0%, #d32f2f 100%);">
                    <i class="fas fa-lock-open"></i> Authenticate & Open Dashboard
                </button>
            </form>

            <div style="text-align: center; margin-top: 1rem; font-size: 0.9rem;">
                <a href="index.php" style="color: var(--text-secondary); text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Return to Passenger Booking
                </a>
            </div>

            <!-- 1-Click Demo Credentials for Reviewers -->
            <div class="demo-account-pills">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-weight:700;"><i class="fas fa-user-shield"></i> Quick Admin Demo:</span>
                    <span style="font-size:0.75rem; color:#64748b;">(Click to fill)</span>
                </div>
                <button type="button" class="demo-pill-btn" onclick="fillDemoCredentials('admin', 'admin123')">
                    <i class="fas fa-user-gear"></i> Fill Officer Credentials (admin / admin123)
                </button>
            </div>
        </div>
    </div>

    <script src="java/modern-railway.js"></script>
</body>
</html>
