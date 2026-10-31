<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

require_once "db_conn.php";
$passenger_name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : htmlspecialchars($_SESSION['user_name']);

// Fetch latest active bookings
$safe_user = addslashes($passenger_name);
$sql = "SELECT * FROM booking WHERE username='$safe_user' ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    // If no booking for this exact username, fetch global latest for college demo
    $sql = "SELECT * FROM booking ORDER BY id DESC LIMIT 5";
    $result = $conn->query($sql);
}

// Check cancelled tickets for this user
$cancels_sql = "SELECT * FROM cancelbooking WHERE username='$safe_user' ORDER BY id DESC LIMIT 3";
$cancels_res = $conn->query($cancels_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Ticket & Refund Portal | Western Railway E-Ticket</title>
    <link rel="icon" href="image/icon1.png" type="image/png">
    <link rel="stylesheet" href="css/modern-railway.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="railway-bg">

    <!-- Header Navigation -->
    <header class="railway-header">
        <div class="header-container">
            <a href="home.php" class="brand-wrapper">
                <img src="image/icon1.png" alt="WR Emblem" class="brand-logo-img" onerror="this.src='image/icon3.png'">
                <div class="brand-text">
                    <h1>Western <span>Railway</span></h1>
                    <p>UTS Suburban E-Ticketing</p>
                </div>
            </a>

            <nav class="header-nav">
                <a href="home.php" class="nav-link"><i class="fas fa-train"></i> Book Ticket</a>
                <a href="trainteckit.php" class="nav-link"><i class="fas fa-ticket-simple"></i> My Ticket</a>
                <a href="Cencel Teckit.php" class="nav-link active"><i class="fas fa-ban"></i> Cancel Ticket</a>
                <a href="About.php" class="nav-link"><i class="fas fa-circle-info"></i> About System</a>
                <a href="Contect.php" class="nav-link"><i class="fas fa-headset"></i> Rail Madad</a>
            </nav>

            <div class="header-user-panel">
                <div class="user-badge">
                    <div class="user-avatar"><?php echo strtoupper(substr($passenger_name, 0, 1)); ?></div>
                    <span class="user-name"><?php echo $passenger_name; ?></span>
                </div>
                <a href="logout.php" class="btn-logout"><i class="fas fa-power-off"></i> Logout</a>
                <button class="mobile-nav-toggle" onclick="toggleNavDrawer()"><i class="fas fa-bars"></i></button>
            </div>
        </div>
    </header>

    <!-- Mobile Drawer Overlay & Nav -->
    <div class="drawer-overlay" id="drawerOverlay" onclick="closeNavDrawer()"></div>
    <div class="mobile-drawer" id="mobileDrawer">
        <div class="mobile-drawer-header">
            <div style="display:flex; align-items:center; gap:0.5rem; color:#ffffff;">
                <img src="image/icon1.png" width="28" height="28" alt="Logo">
                <span style="font-weight:700;">Western Railway</span>
            </div>
            <button onclick="closeNavDrawer()" style="background:none; border:none; color:#ffffff; font-size:1.25rem; cursor:pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mobile-drawer-links">
            <a href="home.php" class="nav-link"><i class="fas fa-train"></i> Book Ticket</a>
            <a href="trainteckit.php" class="nav-link"><i class="fas fa-ticket-simple"></i> View Current Ticket</a>
            <a href="Cencel Teckit.php" class="nav-link active"><i class="fas fa-ban"></i> Cancel Ticket</a>
            <a href="About.php" class="nav-link"><i class="fas fa-circle-info"></i> About Route & Network</a>
            <a href="Contect.php" class="nav-link"><i class="fas fa-headset"></i> Passenger Grievance</a>
            <a href="logout.php" class="btn-danger" style="margin-top:2rem;"><i class="fas fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <!-- Main Container -->
    <main class="main-wrapper">
        <div class="glass-card">
            <div class="glass-card-header" style="background: linear-gradient(135deg, #7f1d1d 0%, #b91c1c 100%);">
                <h2><i class="fas fa-ticket-slash"></i> Ticket Cancellation & Instant Refund System</h2>
                <span style="font-size: 0.85rem; color: #fecaca;"><i class="fas fa-clock-rotate-left"></i> Standard 24h Refund Guarantee</span>
            </div>

            <div class="glass-card-body">
                <!-- Refund Policy Banner -->
                <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: var(--radius-lg); padding: 1rem 1.25rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #fee2e2; color: var(--wr-crimson); display:flex; align-items:center; justify-content:center; font-size:1.25rem; flex-shrink:0;">
                        <i class="fas fa-hand-holding-dollar"></i>
                    </div>
                    <div style="font-size: 0.88rem; color: #991b1b; line-height: 1.4;">
                        <strong>Railway Suburban Cancellation Rules:</strong> Unused suburban tickets can be cancelled before departure. As per Indian Railways suburban policy, nominal clerkage charge (₹5) is deducted and the remainder is automatically credited back to your original payment method.
                    </div>
                </div>

                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.25rem; color: var(--wr-navy-900);">
                    <i class="fas fa-clock"></i> Active Bookings Available for Cancellation:
                </h3>

                <?php 
                $count = 0;
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $count++;
                        $fare = (float)$row['tvalue'];
                        $deduction = min(5.00, $fare);
                        $refund = max(0.00, $fare - $deduction);
                ?>
                <div style="background: #ffffff; border: 2px solid #e2e8f0; border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1.25rem; transition: all 0.2s ease;">
                    <form action="Teckitconne2.php" method="POST" onsubmit="return confirmCancellation(<?php echo $fare; ?>, <?php echo $refund; ?>);">
                        <input type="hidden" name="trn" value="<?php echo htmlspecialchars($row['tnom']); ?>">
                        <input type="hidden" name="trn1" value="<?php echo htmlspecialchars($row['trnNo']); ?>">
                        <input type="hidden" name="dst" value="<?php echo htmlspecialchars($row['tdastinaton']); ?>">
                        <input type="hidden" name="mode" value="<?php echo htmlspecialchars($row['tstatus']); ?>">
                        <input type="hidden" name="pric" value="<?php echo $fare; ?>">
                        <input type="hidden" name="uname1" value="<?php echo $passenger_name; ?>">
                        <input type="hidden" name="uname2" value="Cancel Ticket">

                        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
                            <div>
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                                    <span class="badge badge-success">Active Valid Ticket</span>
                                    <span style="font-family: var(--font-mono); font-weight: 700; font-size: 0.85rem; color: var(--wr-blue-600);">
                                        UTS Ref: <?php echo htmlspecialchars($row['trnNo']); ?>
                                    </span>
                                </div>
                                <div style="font-size: 1.2rem; font-weight: 800; color: var(--wr-navy-900);">
                                    <?php echo htmlspecialchars($row['tdastinaton']); ?>
                                </div>
                                <div style="font-size: 0.82rem; color: #64748b; margin-top: 0.25rem;">
                                    Train: <strong><?php echo htmlspecialchars($row['tnom']); ?></strong> • 
                                    Mode: <strong><?php echo htmlspecialchars($row['tstatus']); ?> Journey</strong> • 
                                    Passenger: <strong><?php echo htmlspecialchars($row['username']); ?></strong>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 1.5rem;">
                                <div style="text-align: right;">
                                    <div style="font-size: 0.72rem; text-transform: uppercase; color: #64748b; font-weight: 600;">Original Fare</div>
                                    <div style="font-size: 1.15rem; font-weight: 700; color: #64748b; text-decoration: line-through;">
                                        ₹<?php echo number_format($fare, 2); ?>
                                    </div>
                                    <div style="font-size: 0.72rem; font-weight: 700; color: var(--wr-green);">
                                        Refund: ₹<?php echo number_format($refund, 2); ?>
                                    </div>
                                </div>

                                <button type="submit" class="btn-danger" style="width: auto; padding: 0.8rem 1.5rem;">
                                    <i class="fas fa-trash-can"></i> Cancel Ticket
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php 
                    }
                } 
                if ($count === 0) { 
                ?>
                <div style="text-align: center; padding: 3rem 1.5rem; background: #f8fafc; border-radius: var(--radius-lg); border: 1px dashed #cbd5e1;">
                    <div style="font-size: 2.5rem; color: #94a3b8; margin-bottom: 0.75rem;"><i class="fas fa-ticket-simple"></i></div>
                    <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--wr-navy-900);">No Active Tickets Found</h4>
                    <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1.25rem;">You do not have any tickets currently eligible for cancellation.</p>
                    <a href="home.php" class="btn-primary" style="width: auto; display: inline-flex;">
                        <i class="fas fa-train"></i> Book a Ticket Now
                    </a>
                </div>
                <?php } ?>

                <!-- Cancellation History (if any) -->
                <?php if ($cancels_res && $cancels_res->num_rows > 0) { ?>
                <div style="margin-top: 2.5rem;">
                    <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-secondary);">
                        <i class="fas fa-clock-rotate-left"></i> Previous Cancellations & Refund Logs
                    </h4>
                    <div class="table-responsive">
                        <table class="railway-table">
                            <thead>
                                <tr>
                                    <th>Ticket Ref</th>
                                    <th>Route</th>
                                    <th>Fare</th>
                                    <th>Refund Status</th>
                                    <th>Cancellation Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($c_row = $cancels_res->fetch_assoc()) { ?>
                                <tr>
                                    <td style="font-family:var(--font-mono); font-weight:700;"><?php echo htmlspecialchars($c_row['TrNo']); ?></td>
                                    <td><?php echo htmlspecialchars($c_row['cdastinaton']); ?></td>
                                    <td>₹<?php echo number_format((float)$c_row['cvalue'], 2); ?></td>
                                    <td><span class="badge badge-success"><i class="fas fa-check"></i> <?php echo htmlspecialchars($c_row['refund_status'] ?? 'Refund Credited'); ?></span></td>
                                    <td><?php echo date('d M Y, h:i A', strtotime($c_row['cancel_time'] ?? 'now')); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="railway-footer">
        <div class="footer-bottom" style="margin-top:0;">
            &copy; <?php echo date('Y'); ?> Western Railway Suburban Division • Official Passenger Ticketing Portal
        </div>
    </footer>

    <script src="java/modern-railway.js"></script>
    <script>
        function confirmCancellation(originalFare, refundAmount) {
            return confirm(`Are you sure you want to cancel this ticket?\n\nOriginal Fare: ₹${originalFare.toFixed(2)}\nCancellation Clerkage Fee: ₹5.00\nNet Refund Amount: ₹${refundAmount.toFixed(2)}\n\nThe refund will be processed back to your original payment method.`);
        }
    </script>
</body>
</html>
