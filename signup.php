<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Registration | Western Railway E-Ticket Portal</title>
    <link rel="icon" href="image/icon1.png" type="image/png">
    <link rel="stylesheet" href="css/modern-railway.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="auth-page-wrapper">

    <div class="auth-card" style="max-width: 480px;">
        <div class="auth-header">
            <img src="image/icon1.png" alt="Indian Railways Logo" class="auth-header-logo" onerror="this.src='image/icon3.png'">
            <h2>Create Passenger Account</h2>
            <p>Western Railway Mumbai Suburban E-Ticketing</p>
        </div>

        <div class="auth-body">
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

            <form action="signup-check.php" method="POST">
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="name"><i class="fas fa-id-card"></i> Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Manoj Gupta" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>" required autofocus>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="uname"><i class="fas fa-user-tag"></i> Username</label>
                    <input type="text" id="uname" name="uname" class="form-control" placeholder="Choose unique username" value="<?php echo isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : ''; ?>" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email (Optional)</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="name@domain.com" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="mobile"><i class="fas fa-phone"></i> Mobile No</label>
                        <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="10-digit mobile" maxlength="10">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Create password" required>
                    </div>
                    <div class="form-group">
                        <label for="re_password"><i class="fas fa-shield"></i> Confirm</label>
                        <input type="password" id="re_password" name="re_password" class="form-control" placeholder="Repeat password" required>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="margin-bottom: 1rem;">
                    <i class="fas fa-user-plus"></i> Register Passenger Account
                </button>
            </form>

            <div style="text-align: center; margin-top: 1rem; font-size: 0.9rem;">
                Already registered? <a href="index.php" style="color: var(--wr-blue-600); font-weight: 700; text-decoration: none;">Login here</a>
            </div>
        </div>
    </div>

    <script src="java/modern-railway.js"></script>
</body>
</html>
