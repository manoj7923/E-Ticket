<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Login | Western Railway E-Ticket Portal</title>
    <link rel="icon" href="image/icon1.png" type="image/png">
    <link rel="stylesheet" href="css/modern-railway.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="auth-page-wrapper">

    <div class="auth-card">
        <div class="auth-header">
            <img src="image/icon1.png" alt="Indian Railways Logo" class="auth-header-logo" onerror="this.src='image/icon3.png'">
            <h2>Western Railway E-Ticket</h2>
            <p>UTS Suburban Ticketing System • Mumbai Local</p>
        </div>

        <div class="auth-body">
            <!-- Mode Switcher -->
            <div class="trip-type-segmented" style="margin-bottom: 1.5rem;">
                <a href="index.php" class="trip-type-btn active" style="text-decoration:none;"><i class="fas fa-user"></i> Passenger Login</a>
                <a href="index1.php" class="trip-type-btn" style="text-decoration:none;"><i class="fas fa-shield-halved"></i> Admin Portal</a>
            </div>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert-box alert-danger">
                    <i class="fas fa-triangle-exclamation"></i>
                    <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <div class="alert-box alert-success">
                    <i class="fas fa-circle-check"></i>
                    <span><?php echo htmlspecialchars($_GET['success']); ?></span>
                </div>
            <?php } ?>

            <form action="login.php" method="POST">
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="uname"><i class="fas fa-user-circle"></i> Username</label>
                    <input type="text" id="uname" name="uname" class="form-control" placeholder="Enter your username" required autofocus>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="btn-primary" style="margin-bottom: 1rem;">
                    <i class="fas fa-right-to-bracket"></i> Login to E-Ticket
                </button>
            </form>

            <div style="text-align: center; margin-top: 1rem; font-size: 0.9rem;">
                Don't have an account? <a href="signup.php" style="color: var(--wr-blue-600); font-weight: 700; text-decoration: none;">Create Free Account</a>
            </div>

            <!-- 1-Click Demo Credentials for Reviewers -->
            <div class="demo-account-pills">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-weight:700;"><i class="fas fa-key"></i> Quick Demo Login:</span>
                    <span style="font-size:0.75rem; color:#64748b;">(Click to test instantly)</span>
                </div>
                <a href="https://your-demo-url.vercel.app" target="_blank" style="display: block; margin-top: 10px; padding: 10px; background: #2563eb; color: #ffffff; text-align: center; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 0.85rem;">
    🚀 Open Live Demo Website</a>
            </div>
        </div>
    </div>

    <script src="java/modern-railway.js"></script>
</body>
</html>
