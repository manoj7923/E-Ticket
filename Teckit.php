<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

require_once "db_conn.php";
$passenger_name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : htmlspecialchars($_SESSION['user_name']);

// Fetch latest order details
$sql = "SELECT o1.id, o1.ffrom, o1.fto, o1.fdate, o1.fstatus, o1.journey_class, o1.network_line, o1.interchange,
               s1.ssingle, s1.RReturn, t1.numbertrain, t1.returnTno, t1.ticketNo 
        FROM ordertick o1
        LEFT JOIN sstatus s1 ON 1=1
        LEFT JOIN trains t1 ON 1=1
        ORDER BY o1.id DESC LIMIT 1";

$result = $conn->query($sql);
$row = ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;

$from_station = $row['ffrom'] ?? ($_SESSION['last_from'] ?? 'Churchgate');
$to_station   = $row['fto'] ?? ($_SESSION['last_to'] ?? 'Borivali');
$journey_date = $row['fdate'] ?? date('Y-m-d');
$pref_status  = $row['fstatus'] ?? 'Single';
$travel_class = $row['journey_class'] ?? ($_SESSION['last_class'] ?? 'Second Class');
$network_line = $row['network_line'] ?? ($_SESSION['last_line'] ?? 'Western Line');
$interchange  = $row['interchange'] ?? ($_SESSION['last_interchange'] ?? 'Direct Journey');

$single_fare  = !empty($row['ssingle']) ? (float)$row['ssingle'] : 15.00;
$return_fare  = !empty($row['RReturn']) ? (float)$row['RReturn'] : 30.00;

// Train numbering based on network line
$train_no     = !empty($row['numbertrain']) ? $row['numbertrain'] : (strpos($network_line, 'Central') !== false ? 'CR-10101' : (strpos($network_line, 'Harbour') !== false ? 'HR-20101' : 'WR-90101'));
$ret_train_no = !empty($row['returnTno']) ? $row['returnTno'] : (strpos($network_line, 'Central') !== false ? 'CR-10102' : (strpos($network_line, 'Harbour') !== false ? 'HR-20102' : 'WR-90102'));
$ticket_token = !empty($row['ticketNo']) ? $row['ticketNo'] : 'UTS' . rand(10000, 99999);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Local Train & Ticket Type | Mumbai Suburban System</title>
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
                    <h1>Mumbai <span>Suburban Rail</span></h1>
                    <p>Western • Central • Harbour Lines (CRIS UTS)</p>
                </div>
            </a>

            <nav class="header-nav">
                <a href="home.php" class="nav-link"><i class="fas fa-train"></i> Book Ticket</a>
                <a href="trainteckit.php" class="nav-link"><i class="fas fa-ticket-simple"></i> My Ticket</a>
                <a href="Cencel Teckit.php" class="nav-link"><i class="fas fa-ban"></i> Cancel Ticket</a>
                <a href="About.php" class="nav-link"><i class="fas fa-circle-info"></i> Network Info</a>
                <a href="Contect.php" class="nav-link"><i class="fas fa-headset"></i> Rail Madad</a>
            </nav>

            <div class="header-user-panel">
                <div class="live-clock-badge">
                    <span class="live-pulse-dot"></span>
                    <i class="far fa-clock"></i>
                    <span id="liveClock">--:--:--</span> IST
                </div>
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
                <span style="font-weight:700;">Mumbai Suburban Rail</span>
            </div>
            <button onclick="closeNavDrawer()" style="background:none; border:none; color:#ffffff; font-size:1.25rem; cursor:pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mobile-drawer-links">
            <a href="home.php" class="nav-link"><i class="fas fa-train"></i> Book Ticket</a>
            <a href="trainteckit.php" class="nav-link"><i class="fas fa-ticket-simple"></i> View Current Ticket</a>
            <a href="Cencel Teckit.php" class="nav-link"><i class="fas fa-ban"></i> Cancel Ticket</a>
            <a href="About.php" class="nav-link"><i class="fas fa-circle-info"></i> Network Info</a>
            <a href="Contect.php" class="nav-link"><i class="fas fa-headset"></i> Passenger Grievance</a>
            <a href="logout.php" class="btn-danger" style="margin-top:2rem;"><i class="fas fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-wrapper">
        <div class="glass-card">
            <div class="glass-card-header">
                <h2><i class="fas fa-route"></i> Select Available Local Train & Journey Type</h2>
                <span class="badge-12h"><i class="fas fa-clock"></i> 12 Hours Validity On Confirmation</span>
            </div>

            <div class="glass-card-body">
                <!-- Journey Brief Box -->
                <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border: 1px solid #bae6fd; border-radius: var(--radius-lg); padding: 1.25rem 1.75rem; margin-bottom: 2rem; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
                    <div>
                        <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.25rem;">
                            <span class="badge badge-wr"><?php echo htmlspecialchars($network_line); ?></span>
                            <?php if ($interchange !== 'Direct Journey' && $interchange !== 'Direct Non-Stop Journey') { ?>
                                <span class="badge badge-interchange"><i class="fas fa-shuffle"></i> <?php echo htmlspecialchars($interchange); ?></span>
                            <?php } ?>
                        </div>
                        <div style="font-size: 1.35rem; font-weight: 800; color: #0c4a6e;">
                            <?php echo htmlspecialchars($from_station); ?> ➔ <?php echo htmlspecialchars($to_station); ?>
                        </div>
                        <div style="font-size:0.82rem; color:#64748b; margin-top:0.25rem;">
                            Class: <strong><?php echo htmlspecialchars($travel_class); ?></strong> • Date: <strong><?php echo htmlspecialchars($journey_date); ?></strong> • Validity: <strong style="color:var(--wr-green);"><i class="fas fa-check"></i> 12 Hours</strong>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <span class="badge badge-success" style="padding:0.4rem 0.8rem; font-size:0.82rem;">
                            <i class="fas fa-shield-check"></i> All Lines Accepted
                        </span>
                    </div>
                </div>

                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: var(--wr-navy-900);">
                    <i class="fas fa-list-check"></i> Available Suburban Ticket Options:
                </h3>

                <!-- Ticket Option 1: Single Journey -->
                <div style="background: #ffffff; border: 2px solid #e2e8f0; border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1.25rem; transition: border-color 0.2s ease, box-shadow 0.2s ease;" onmouseover="this.style.borderColor='var(--wr-blue-600)'" onmouseout="this.style.borderColor='#e2e8f0'">
                    <form action="Teckitconne.php" method="POST" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;">
                        <input type="hidden" name="trn" value="<?php echo htmlspecialchars($train_no); ?>">
                        <input type="hidden" name="dst" value="<?php echo htmlspecialchars($from_station); ?> To <?php echo htmlspecialchars($to_station); ?>">
                        <input type="hidden" name="mode" value="Single">
                        <input type="hidden" name="pric" value="<?php echo $single_fare; ?>">
                        <input type="hidden" name="uname1" value="<?php echo $passenger_name; ?>">
                        <input type="hidden" name="pay2" value="<?php echo htmlspecialchars($ticket_token); ?>">
                        <input type="hidden" name="network_line" value="<?php echo htmlspecialchars($network_line); ?>">

                        <div style="display: flex; align-items: center; gap: 1.25rem;">
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: var(--wr-blue-100); color: var(--wr-blue-600); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;">
                                1
                            </div>
                            <div>
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                    <span class="badge badge-info">Single Journey</span>
                                    <span style="font-family: var(--font-mono); font-weight: 700; font-size: 0.9rem; color: var(--wr-navy-800);">
                                        Train <?php echo htmlspecialchars($train_no); ?>
                                    </span>
                                    <span class="badge-12h" style="padding:0.15rem 0.5rem; font-size:0.7rem;"><i class="fas fa-clock"></i> 12h Valid</span>
                                </div>
                                <div style="font-size: 0.95rem; font-weight: 700; color: var(--text-primary);">
                                    <?php echo htmlspecialchars($from_station); ?> ➔ <?php echo htmlspecialchars($to_station); ?>
                                </div>
                                <div style="font-size: 0.78rem; color: #64748b;">
                                    <i class="fas fa-clock"></i> Next service in ~5 mins • Valid for 12 hours from confirmation
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 1.5rem;">
                            <div style="text-align: right;">
                                <div style="font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 600;">Total Amount</div>
                                <div style="font-size: 1.6rem; font-weight: 800; color: var(--wr-navy-900); font-family: var(--font-mono);">
                                    ₹<?php echo number_format($single_fare, 2); ?>
                                </div>
                            </div>

                            <button type="submit" class="btn-primary" style="width: auto; padding: 0.8rem 1.75rem;">
                                <i class="fas fa-check-circle"></i> Book Single Ticket
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Ticket Option 2: Return Journey -->
                <div style="background: #ffffff; border: 2px solid #e2e8f0; border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1.5rem; transition: border-color 0.2s ease, box-shadow 0.2s ease;" onmouseover="this.style.borderColor='var(--wr-blue-600)'" onmouseout="this.style.borderColor='#e2e8f0'">
                    <form action="Teckitconne.php" method="POST" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;">
                        <input type="hidden" name="trn" value="<?php echo htmlspecialchars($ret_train_no); ?>">
                        <input type="hidden" name="dst" value="<?php echo htmlspecialchars($from_station); ?> To <?php echo htmlspecialchars($to_station); ?>">
                        <input type="hidden" name="mode" value="Return">
                        <input type="hidden" name="pric" value="<?php echo $return_fare; ?>">
                        <input type="hidden" name="uname1" value="<?php echo $passenger_name; ?>">
                        <input type="hidden" name="pay2" value="<?php echo htmlspecialchars($ticket_token); ?>">
                        <input type="hidden" name="network_line" value="<?php echo htmlspecialchars($network_line); ?>">

                        <div style="display: flex; align-items: center; gap: 1.25rem;">
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: var(--wr-green-light); color: var(--wr-green); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;">
                                2
                            </div>
                            <div>
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                    <span class="badge badge-success">Return Journey (Round Trip)</span>
                                    <span style="font-family: var(--font-mono); font-weight: 700; font-size: 0.9rem; color: var(--wr-navy-800);">
                                        Train <?php echo htmlspecialchars($ret_train_no); ?>
                                    </span>
                                    <span class="badge-12h" style="padding:0.15rem 0.5rem; font-size:0.7rem;"><i class="fas fa-clock"></i> 12h Valid</span>
                                </div>
                                <div style="font-size: 0.95rem; font-weight: 700; color: var(--text-primary);">
                                    <?php echo htmlspecialchars($from_station); ?> ⇄ <?php echo htmlspecialchars($to_station); ?>
                                </div>
                                <div style="font-size: 0.78rem; color: #64748b;">
                                    <i class="fas fa-arrows-spin"></i> Outward & Return journey included • Valid 12 hours from issue
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 1.5rem;">
                            <div style="text-align: right;">
                                <div style="font-size: 0.72rem; text-transform: uppercase; color: #64748b; font-weight: 600;">Total Amount</div>
                                <div style="font-size: 1.6rem; font-weight: 800; color: var(--wr-navy-900); font-family: var(--font-mono);">
                                    ₹<?php echo number_format($return_fare, 2); ?>
                                </div>
                            </div>

                            <button type="submit" class="btn-primary" style="width: auto; padding: 0.8rem 1.75rem; background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                                <i class="fas fa-check-double"></i> Book Return Ticket
                            </button>
                        </div>
                    </form>
                </div>

                <div style="display: flex; justify-content: flex-start;">
                    <a href="home.php" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i> Change Route / Stations
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Railway Footer -->
    <footer class="railway-footer">
        <div class="footer-bottom" style="margin-top:0;">
            &copy; <?php echo date('Y'); ?> Mumbai Suburban Railway Ticketing • Western, Central & Harbour Lines
        </div>
    </footer>

    <script src="java/modern-railway.js"></script>
</body>
</html>
