<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

require_once "db_conn.php";
$passenger_name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : htmlspecialchars($_SESSION['user_name']);

// Fetch user complaints
$safe_name = addslashes($passenger_name);
$sql = "SELECT * FROM complaint WHERE cname='$safe_name' OR cemail LIKE '%$safe_name%' ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $sql = "SELECT * FROM complaint ORDER BY id DESC LIMIT 5";
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rail Madad Support & Passenger Grievance | Western Railway</title>
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
                <a href="Cencel Teckit.php" class="nav-link"><i class="fas fa-ban"></i> Cancel Ticket</a>
                <a href="About.php" class="nav-link"><i class="fas fa-circle-info"></i> About System</a>
                <a href="Contect.php" class="nav-link active"><i class="fas fa-headset"></i> Rail Madad</a>
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
            <a href="Cencel Teckit.php" class="nav-link"><i class="fas fa-ban"></i> Cancel Ticket</a>
            <a href="About.php" class="nav-link"><i class="fas fa-circle-info"></i> About Route & Network</a>
            <a href="Contect.php" class="nav-link active"><i class="fas fa-headset"></i> Passenger Grievance</a>
            <a href="logout.php" class="btn-danger" style="margin-top:2rem;"><i class="fas fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <!-- Main Container -->
    <main class="main-wrapper">
        <div class="glass-card">
            <div class="glass-card-header" style="background: linear-gradient(135deg, #0b2545 0%, #1e40af 100%);">
                <h2><i class="fas fa-headset"></i> Rail Madad Passenger Support & Grievance Redressal</h2>
                <span style="font-size:0.85rem; color:#93c5fd;"><i class="fas fa-shield"></i> Indian Railways Official Helpdesk</span>
            </div>

            <div class="glass-card-body">
                <?php if (isset($_GET['sent']) && $_GET['sent'] === 'success') { ?>
                    <div class="alert-box alert-success" style="margin-bottom: 1.5rem;">
                        <i class="fas fa-circle-check"></i>
                        <span>Thank you! Your grievance / inquiry has been officially lodged. Reference ticket ID generated.</span>
                    </div>
                <?php } ?>

                <div style="display: grid; grid-template-columns: 3fr 2fr; gap: 2rem; align-items: start;">
                    <!-- Grievance Form -->
                    <div>
                        <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 1rem; color: var(--wr-navy-900);">
                            <i class="fas fa-pen-to-square"></i> Lodge a Grievance / Feedback
                        </h3>

                        <form action="mailconnect.php" method="POST">
                            <div class="form-group" style="margin-bottom: 1rem;">
                                <label for="cname"><i class="fas fa-user"></i> Passenger Name</label>
                                <input type="text" id="cname" name="name" class="form-control" value="<?php echo $passenger_name; ?>" required>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div class="form-group">
                                    <label for="cemail"><i class="fas fa-envelope"></i> Email Address</label>
                                    <input type="email" id="cemail" name="Email" class="form-control" placeholder="name@example.com" required value="<?php echo strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $passenger_name)); ?>@example.com">
                                </div>

                                <div class="form-group">
                                    <label for="cmobile"><i class="fas fa-phone"></i> Mobile Number</label>
                                    <input type="tel" id="cmobile" name="mobile" class="form-control" placeholder="10-digit mobile" maxlength="10" required value="9876543210">
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom: 1rem;">
                                <label for="category"><i class="fas fa-tag"></i> Complaint / Inquiry Category</label>
                                <select id="category" name="category" class="form-control">
                                    <option value="Ticket Booking Issue">Ticket Booking / Payment Deducted</option>
                                    <option value="Refund Delay">Refund Inquiries & Cancellation</option>
                                    <option value="Suburban EMU Cleanliness">Coach & Station Cleanliness</option>
                                    <option value="Schedule & Train Delay">Train Frequency / AC Local Schedule</option>
                                    <option value="Security & Safety">Security & Railway Police Helpline</option>
                                    <option value="General Suggestion">General Suggestion & Feedback</option>
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <label for="complaintText"><i class="fas fa-message"></i> Detailed Grievance Description</label>
                                <textarea id="complaintText" name="complaint" class="form-control" style="height: 140px; resize: vertical;" placeholder="Please describe your experience, journey date, or ticket reference..." required></textarea>
                            </div>

                            <button type="submit" class="btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit to Commercial Division
                            </button>
                        </form>
                    </div>

                    <!-- Emergency Helplines & Contact Info -->
                    <div>
                        <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1.5rem;">
                            <h4 style="font-size: 1rem; font-weight: 700; color: var(--wr-navy-900); margin-bottom: 1rem;">
                                <i class="fas fa-phone-volume" style="color:var(--wr-crimson);"></i> Official Railway Helplines
                            </h4>

                            <div style="display: flex; flex-direction: column; gap: 0.85rem; font-size: 0.88rem;">
                                <div style="display:flex; justify-content:space-between; padding-bottom:0.5rem; border-bottom:1px solid #e2e8f0;">
                                    <span>Rail Madad All-in-One:</span>
                                    <strong style="color:var(--wr-blue-600); font-family:var(--font-mono); font-size:1rem;">139</strong>
                                </div>
                                <div style="display:flex; justify-content:space-between; padding-bottom:0.5rem; border-bottom:1px solid #e2e8f0;">
                                    <span>Railway Protection Force (RPF):</span>
                                    <strong style="color:var(--wr-crimson); font-family:var(--font-mono); font-size:1rem;">182</strong>
                                </div>
                                <div style="display:flex; justify-content:space-between; padding-bottom:0.5rem; border-bottom:1px solid #e2e8f0;">
                                    <span>Mumbai GRP Suburban Helpline:</span>
                                    <strong style="color:var(--wr-navy-900); font-family:var(--font-mono); font-size:1rem;">1512</strong>
                                </div>
                                <div style="display:flex; justify-content:space-between;">
                                    <span>Women Helpline (WR Security):</span>
                                    <strong style="color:#059669; font-family:var(--font-mono); font-size:1rem;">9004499718</strong>
                                </div>
                            </div>
                        </div>

                        <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe; border-radius: var(--radius-lg); padding: 1.25rem;">
                            <h5 style="font-size: 0.95rem; font-weight: 700; color: #1e40af; margin-bottom: 0.5rem;">
                                <i class="fas fa-building"></i> Western Railway Headquarters
                            </h5>
                            <p style="font-size: 0.82rem; color: #1e3a8a; line-height: 1.5;">
                                Office of the Chief Commercial Manager,<br>
                                Western Railway Headquarters Building,<br>
                                Churchgate, Mumbai - 400020, Maharashtra.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Existing Grievance Status -->
                <?php if ($result && $result->num_rows > 0) { ?>
                <div style="margin-top: 3rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                    <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 1rem; color: var(--wr-navy-900);">
                        <i class="fas fa-list-check"></i> Recent Grievance Status Logs
                    </h3>

                    <div class="table-responsive">
                        <table class="railway-table">
                            <thead>
                                <tr>
                                    <th>Ref ID</th>
                                    <th>Passenger</th>
                                    <th>Category</th>
                                    <th>Summary</th>
                                    <th>Status</th>
                                    <th>Lodged Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($comp = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td style="font-family:var(--font-mono); font-weight:700;">#GR-<?php echo $comp['id']; ?></td>
                                    <td><?php echo htmlspecialchars($comp['cname']); ?></td>
                                    <td><span class="badge badge-info"><?php echo htmlspecialchars($comp['category'] ?? 'General'); ?></span></td>
                                    <td style="max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <?php echo htmlspecialchars($comp['ccomplaint']); ?>
                                    </td>
                                    <td>
                                        <?php if (($comp['status'] ?? '') === 'Resolved') { ?>
                                            <span class="badge badge-success"><i class="fas fa-circle-check"></i> Resolved</span>
                                        <?php } else { ?>
                                            <span class="badge badge-warning"><i class="fas fa-spinner fa-spin"></i> In Review</span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($comp['created_at'] ?? 'now')); ?></td>
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
            &copy; <?php echo date('Y'); ?> Western Railway Suburban Division • Rail Madad Grievance Management
        </div>
    </footer>

    <script src="java/modern-railway.js"></script>
</body>
</html>
