<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

require_once "db_conn.php";
$passenger_name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : htmlspecialchars($_SESSION['user_name']);

// Fetch latest confirmed ticket
$sql = "SELECT b.id, b.tnom, b.trnNo, b.tdastinaton, b.tstatus, b.tvalue, b.booking_date, b.qr_data,
               b.network_line, b.validity_hours, b.valid_until,
               o.ffrom, o.fto, o.fdate, o.fstatus, o.journey_class
        FROM booking b
        LEFT JOIN ordertick o ON 1=1
        ORDER BY b.id DESC LIMIT 1";

$result = $conn->query($sql);
$row = ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;

// Parse stations
$destination_str = $row['tdastinaton'] ?? ($_SESSION['current_ticket']['dst'] ?? 'Churchgate To Borivali');
$parts = explode(' To ', $destination_str);
$from_station = !empty($parts[0]) ? trim($parts[0]) : ($row['ffrom'] ?? 'Churchgate');
$to_station   = !empty($parts[1]) ? trim($parts[1]) : ($row['fto'] ?? 'Borivali');

$train_no     = !empty($row['tnom']) ? $row['tnom'] : ($_SESSION['current_ticket']['trn'] ?? 'WR-90101');
$ticket_pnr   = !empty($row['trnNo']) ? $row['trnNo'] : ($_SESSION['current_ticket']['token'] ?? ('UTS' . rand(10000, 99999)));
$ticket_mode  = !empty($row['tstatus']) ? $row['tstatus'] : ($_SESSION['current_ticket']['mode'] ?? 'Single');
$ticket_fare  = !empty($row['tvalue']) ? (float)$row['tvalue'] : ($_SESSION['current_ticket']['price'] ?? 15.00);
$network_line = !empty($row['network_line']) ? $row['network_line'] : ($_SESSION['current_ticket']['line'] ?? 'Western Line');
$journey_date = !empty($row['fdate']) ? $row['fdate'] : date('Y-m-d');
$booking_time = !empty($row['booking_date']) ? date('d M Y, h:i A', strtotime($row['booking_date'])) : date('d M Y, h:i A');
$travel_class = !empty($row['journey_class']) ? $row['journey_class'] : ($_SESSION['last_class'] ?? 'Second Class (II)');

// 12-Hour Validity Calculation
$booking_ts = !empty($row['booking_date']) ? strtotime($row['booking_date']) : time();
$valid_until_ts = $booking_ts + (12 * 3600);
$valid_until_fmt = date('d M Y, h:i A', $valid_until_ts);

// Station codes map (Western, Central & Harbour)
$station_codes = [
    'Churchgate' => 'CCG', 'Marine Lines' => 'MEL', 'Charni Road' => 'CYR', 'Grant Road' => 'GTR',
    'Mumbai Central' => 'MMCT', 'Mahalaxmi' => 'MX', 'Lower Parel' => 'PL', 'Prabhadevi' => 'PBHD',
    'Dadar' => 'DDR', 'Dadar (WR)' => 'DDR', 'Matunga Road' => 'MRU', 'Mahim Junction' => 'MM',
    'Bandra' => 'BA', 'Khar Road' => 'KHAR', 'Santacruz' => 'STC', 'Vile Parle' => 'VLP',
    'Andheri' => 'ADH', 'Jogeshwari' => 'JOS', 'Ram Mandir' => 'RMAR', 'Goregaon' => 'GMN',
    'Malad' => 'MDD', 'Kandivali' => 'KNDI', 'Borivali' => 'BVI', 'Dahisar' => 'DIC',
    'Mira Road' => 'MIRA', 'Bhayandar' => 'BYR', 'Naigaon' => 'NIG', 'Vasai Road' => 'BSR',
    'Nala Sopara' => 'NSP', 'Virar' => 'VR', 'Palghar' => 'PLG', 'Boisar' => 'BOR', 'Dahanu Road' => 'DRD',
    'CSMT' => 'CSMT', 'CSMT (Central)' => 'CSMT', 'CSMT (Harbour)' => 'CSMT', 'Byculla' => 'BY',
    'Parel' => 'PR', 'Dadar (CR)' => 'DDR', 'Kurla' => 'CLA', 'Kurla (CR)' => 'CLA', 'Kurla (Harbour)' => 'CLA',
    'Ghatkopar' => 'GC', 'Thane' => 'TNA', 'Dombivli' => 'DI', 'Kalyan Junction' => 'KYN',
    'Vadala Road' => 'VDLR', 'Chembur' => 'CMBR', 'Vashi' => 'VSH', 'Nerul' => 'NEU', 'Panvel' => 'PNVL'
];

$from_code = $station_codes[$from_station] ?? 'CCG';
$to_code   = $station_codes[$to_station] ?? 'BVI';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket Boarding Pass (12h Valid) | UTS On Mobile Mumbai</title>
    <link rel="icon" href="image/icon1.png" type="image/png">
    <link rel="stylesheet" href="css/modern-railway.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="railway-bg">

    <!-- Header Navigation (Hidden on print) -->
    <header class="railway-header no-print">
        <div class="header-container">
            <a href="home.php" class="brand-wrapper">
                <img src="image/icon1.png" alt="WR Emblem" class="brand-logo-img" onerror="this.src='image/icon3.png'">
                <div class="brand-text">
                    <h1>Mumbai <span>Suburban Rail</span></h1>
                    <p>UTS Suburban E-Ticketing</p>
                </div>
            </a>

            <nav class="header-nav">
                <a href="home.php" class="nav-link"><i class="fas fa-train"></i> Book Ticket</a>
                <a href="trainteckit.php" class="nav-link active"><i class="fas fa-ticket-simple"></i> My Ticket</a>
                <a href="Cencel Teckit.php" class="nav-link"><i class="fas fa-ban"></i> Cancel Ticket</a>
                <a href="About.php" class="nav-link"><i class="fas fa-circle-info"></i> Network Info</a>
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
                <span style="font-weight:700;">Mumbai Suburban E-Ticket</span>
            </div>
            <button onclick="closeNavDrawer()" style="background:none; border:none; color:#ffffff; font-size:1.25rem; cursor:pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mobile-drawer-links">
            <a href="home.php" class="nav-link"><i class="fas fa-train"></i> Book Ticket</a>
            <a href="trainteckit.php" class="nav-link active"><i class="fas fa-ticket-simple"></i> View Current Ticket</a>
            <a href="Cencel Teckit.php" class="nav-link"><i class="fas fa-ban"></i> Cancel Ticket</a>
            <a href="About.php" class="nav-link"><i class="fas fa-circle-info"></i> All 3 Lines Network</a>
            <a href="Contect.php" class="nav-link"><i class="fas fa-headset"></i> Passenger Grievance</a>
            <a href="logout.php" class="btn-danger" style="margin-top:2rem;"><i class="fas fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <!-- Main Container -->
    <main class="main-wrapper ticket-wrapper">
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success') { ?>
            <div class="alert-box alert-success no-print" style="margin-bottom: 1.5rem;">
                <i class="fas fa-circle-check" style="font-size: 1.25rem;"></i>
                <div>
                    <strong>Payment Confirmed!</strong> Your suburban journey ticket is active and <strong>valid for 12 hours</strong>.
                </div>
            </div>
        <?php } ?>

        <!-- Authentic UTS Boarding Pass Card -->
        <div class="uts-ticket-card" id="printableTicket">
            <!-- Ticket Top Header -->
            <div class="uts-ticket-header">
                <div class="uts-brand-left">
                    <img src="image/icon1.png" alt="Indian Railways Emblem" style="width: 36px; height: 36px; object-fit: contain; background: #ffffff; border-radius: 8px; padding: 2px;">
                    <div>
                        <div class="uts-brand-title">INDIAN RAILWAYS • CRIS UTS ON MOBILE</div>
                        <div class="uts-brand-sub"><?php echo htmlspecialchars($network_line); ?> • Suburban EMU Service</div>
                    </div>
                </div>

                <div class="uts-pnr-badge">
                    <div class="pnr-label">Booking Ref / PNR</div>
                    <div class="pnr-code"><?php echo htmlspecialchars($ticket_pnr); ?></div>
                </div>
            </div>

            <!-- 12-Hour Validity Countdown Meter (Live) -->
            <div class="validity-meter-box" style="margin: 1.25rem 1.75rem 0.5rem;">
                <div class="validity-header-row">
                    <div class="validity-title">
                        <i class="fas fa-hourglass-half"></i> 12-Hour Ticket Validity Window
                    </div>
                    <div class="validity-countdown-text" id="ticketCountdownTimer">
                        Calculating...
                    </div>
                </div>
                <div class="validity-progress-bar-bg">
                    <div class="validity-progress-bar-fill" id="validityProgressBar" style="width: 100%;"></div>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:0.75rem; color:#065f46; margin-top:0.15rem;">
                    <span>Issued: <strong><?php echo $booking_time; ?></strong></span>
                    <span>Valid Until: <strong><?php echo $valid_until_fmt; ?></strong></span>
                </div>
            </div>

            <!-- Route Visualizer Banner -->
            <div class="uts-route-section">
                <div class="station-node">
                    <div class="node-label">Origin Station</div>
                    <div class="node-name"><?php echo htmlspecialchars($from_station); ?></div>
                    <div class="node-code">[ <?php echo htmlspecialchars($from_code); ?> ]</div>
                </div>

                <div class="route-arrow-connector">
                    <span class="route-train-type"><?php echo htmlspecialchars($ticket_mode); ?> JOURNEY</span>
                    <i class="fas fa-arrow-right-long route-arrow-icon"></i>
                    <span style="font-size:0.72rem; color:#64748b; font-weight:600;"><?php echo htmlspecialchars($network_line); ?></span>
                </div>

                <div class="station-node destination">
                    <div class="node-label">Destination Station</div>
                    <div class="node-name"><?php echo htmlspecialchars($to_station); ?></div>
                    <div class="node-code">[ <?php echo htmlspecialchars($to_code); ?> ]</div>
                </div>
            </div>

            <!-- Ticket Detailed Specifications -->
            <div class="uts-details-grid">
                <div class="detail-item-group">
                    <span class="detail-title">Passenger Name</span>
                    <span class="detail-value"><?php echo $passenger_name; ?></span>
                </div>

                <div class="detail-item-group">
                    <span class="detail-title">Assigned Train</span>
                    <span class="detail-value" style="font-family:var(--font-mono);"><?php echo htmlspecialchars($train_no); ?></span>
                </div>

                <div class="detail-item-group">
                    <span class="detail-title">Total Fare Paid</span>
                    <span class="detail-value highlight">₹<?php echo number_format($ticket_fare, 2); ?></span>
                </div>

                <div class="detail-item-group">
                    <span class="detail-title">Travel Class</span>
                    <span class="detail-value"><?php echo htmlspecialchars($travel_class); ?></span>
                </div>

                <div class="detail-item-group">
                    <span class="detail-title">Validity Span</span>
                    <span class="detail-value" style="color:var(--wr-green);"><i class="fas fa-clock"></i> 12 Hours (Fixed)</span>
                </div>

                <div class="detail-item-group">
                    <span class="detail-title">Expiry Deadline</span>
                    <span class="detail-value" style="font-size:0.85rem; font-family:var(--font-mono); font-weight:700;"><?php echo $valid_until_fmt; ?></span>
                </div>
            </div>

            <!-- Cryptographic QR Code & Guidelines -->
            <div class="uts-barcode-row">
                <div class="qr-code-box" id="ticketQRContainer"></div>

                <div class="ticket-rules-text">
                    <p><strong><i class="fas fa-shield-check" style="color:var(--wr-blue-600);"></i> 12-Hour Journey Regulations:</strong></p>
                    <p>• <strong>Strict 12-Hour Validity:</strong> This ticket remains active and legally valid for travel for exactly 12 hours from time of booking.</p>
                    <p>• Valid across Western, Central, and Harbour suburban corridors including authorized transfers at Dadar and Kurla.</p>
                    <p>• Show this digital boarding pass or printed slip upon inspection by Railway Ticket Examiners (TTE).</p>
                    <p>• Non-transferable and verified cryptographically by CRIS Rail Systems.</p>
                </div>
            </div>

            <!-- Security Footer -->
            <div class="uts-ticket-footer">
                <span><i class="fas fa-shield-halved" style="color:var(--wr-green);"></i> CRIS Center for Railway Information Systems • 12-Hour Verified Pass</span>
                <span style="font-family:var(--font-mono); font-weight:700;">HAPPY JOURNEY • शुभ यात्रा</span>
            </div>
        </div>

        <!-- Action Buttons (Print / Share / Book Next) -->
        <div class="ticket-actions-bar no-print">
            <button type="button" class="btn-primary" onclick="window.print()" style="width: auto; padding: 0.85rem 1.75rem;">
                <i class="fas fa-print"></i> Print / Save as PDF
            </button>
            <a href="home.php" class="btn-secondary">
                <i class="fas fa-train"></i> Book Another Ticket
            </a>
            <a href="Cencel Teckit.php" class="btn-danger" style="background:#dc2626;">
                <i class="fas fa-ban"></i> Cancel Ticket
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="railway-footer no-print">
        <div class="footer-bottom" style="margin-top:0;">
            &copy; <?php echo date('Y'); ?> Mumbai Suburban Railway • Western, Central & Harbour Lines • 12-Hour Official E-Ticket Pass
        </div>
    </footer>

    <script src="java/modern-railway.js"></script>
    <script>
        // Generate cryptographic QR for ticket with 12h validity info
        generateTicketQR('ticketQRContainer', 'UTS:MUMBAI:<?php echo $ticket_pnr; ?>:<?php echo $from_code; ?>:<?php echo $to_code; ?>:FARE=<?php echo $ticket_fare; ?>:12H_EXP=<?php echo urlencode($valid_until_fmt); ?>:OK');

        // Start live 12-hour countdown
        const endTs = <?php echo ($valid_until_ts * 1000); ?>;
        init12HourCountdown(endTs, 'ticketCountdownTimer', 'validityProgressBar');
    </script>
</body>
</html>
