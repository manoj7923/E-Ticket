<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

require_once "db_conn.php";
$passenger_name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : htmlspecialchars($_SESSION['user_name']);

// Fetch latest booking
$sql = "SELECT b.id, b.tnom, b.trnNo, b.tdastinaton, b.tstatus, b.tvalue, b.booking_date,
               o.fdate, o.fstatus
        FROM booking b
        LEFT JOIN ordertick o ON 1=1
        ORDER BY b.id DESC LIMIT 1";

$result = $conn->query($sql);
$row = ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;

$fare_amount = !empty($row['tvalue']) ? (float)$row['tvalue'] : ($_SESSION['current_ticket']['price'] ?? 15.00);
$route_title = !empty($row['tdastinaton']) ? $row['tdastinaton'] : ($_SESSION['current_ticket']['dst'] ?? 'Churchgate To Borivali');
$ticket_mode = !empty($row['tstatus']) ? $row['tstatus'] : ($_SESSION['current_ticket']['mode'] ?? 'Single');
$ticket_pnr  = !empty($row['trnNo']) ? $row['trnNo'] : ($_SESSION['current_ticket']['token'] ?? ('UTS' . rand(10000, 99999)));
$train_num   = !empty($row['tnom']) ? $row['tnom'] : ($_SESSION['current_ticket']['trn'] ?? 'WR-90101');

// Determine line badges based on train or route
$line_badge_class = 'badge-wr';
$line_name = 'Western Line';
if (strpos($train_num, 'CR') !== false || stripos($route_title, 'CSMT') !== false || stripos($route_title, 'Kalyan') !== false || stripos($route_title, 'Thane') !== false) {
    $line_badge_class = 'badge-cr';
    $line_name = 'Central Line';
} elseif (strpos($train_num, 'HR') !== false || stripos($route_title, 'Panvel') !== false || stripos($route_title, 'Vashi') !== false) {
    $line_badge_class = 'badge-hr';
    $line_name = 'Harbour Line';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Railway Payment Gateway | UTS On Mobile Mumbai</title>
    <link rel="icon" href="image/icon1.png" type="image/png">
    <link rel="stylesheet" href="css/modern-railway.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="railway-bg">

    <!-- Header Navigation -->
    <header class="railway-header">
        <div class="header-container">
            <a href="home.php" class="brand-wrapper">
                <img src="image/icon1.png" alt="Indian Railways Emblem" class="brand-logo-img" onerror="this.src='image/icon3.png'">
                <div class="brand-text">
                    <h1>Mumbai <span>Suburban Rail</span></h1>
                    <p>UTS Suburban E-Ticketing • Payment</p>
                </div>
            </a>

            <div class="header-user-panel">
                <div class="live-clock-badge">
                    <span class="live-pulse-dot"></span>
                    <i class="fas fa-lock" style="color:var(--wr-green);"></i> 256-bit Secure Gateway
                </div>
                <div class="user-badge">
                    <div class="user-avatar"><?php echo strtoupper(substr($passenger_name, 0, 1)); ?></div>
                    <span class="user-name"><?php echo $passenger_name; ?></span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Payment Container -->
    <main class="main-wrapper" style="max-width: 850px;">
        <div class="glass-card">
            <div class="glass-card-header" style="background: linear-gradient(135deg, #0b2545 0%, #1e3a5f 100%);">
                <h2><i class="fas fa-shield-halved"></i> Railway Payment Gateway</h2>
                <div style="display:flex; align-items:center; gap:0.5rem;">
                    <span class="badge-12h"><i class="fas fa-stopwatch"></i> 12h Validity on Confirmation</span>
                    <span class="badge badge-success"><i class="fas fa-lock"></i> PCI-DSS Compliant</span>
                </div>
            </div>

            <div class="glass-card-body">
                <!-- Order Summary Header -->
                <div style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: var(--radius-lg); padding: 1.25rem 1.75rem; border: 1px solid var(--border-color); margin-bottom: 2rem; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); display:flex; align-items:center; gap:0.5rem;">
                            Journey Summary • <span class="badge <?php echo $line_badge_class; ?>"><?php echo $line_name; ?></span>
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 800; color: var(--wr-navy-900); margin-top: 0.2rem;">
                            <?php echo htmlspecialchars($route_title); ?>
                        </div>
                        <div style="font-size: 0.85rem; color: #64748b; margin-top: 0.3rem;">
                            <span class="badge badge-info"><?php echo htmlspecialchars($ticket_mode); ?> Ticket</span> • 
                            Train: <strong><?php echo htmlspecialchars($train_num); ?></strong> • 
                            Ref Token: <strong><?php echo htmlspecialchars($ticket_pnr); ?></strong>
                        </div>
                    </div>

                    <div style="text-align: right;">
                        <div style="font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 700;">Total Amount Due</div>
                        <div style="font-size: 2.1rem; font-weight: 800; color: var(--wr-navy-900); font-family: var(--font-mono);">
                            ₹<?php echo number_format($fare_amount, 2); ?>
                        </div>
                        <div style="font-size: 0.72rem; color: var(--wr-green); font-weight: 700;">
                            <i class="fas fa-circle-check"></i> All Railway Surcharges Included
                        </div>
                    </div>
                </div>

                <!-- Multi-Method Payment Tabs -->
                <div class="payment-methods-grid">
                    <div class="payment-tabs">
                        <button type="button" class="payment-tab-btn active" onclick="switchPaymentTab('upi', this)">
                            <i class="fas fa-qrcode"></i> UPI & QR Code
                        </button>
                        <button type="button" class="payment-tab-btn" onclick="switchPaymentTab('card', this)">
                            <i class="fas fa-credit-card"></i> Debit / Credit Card
                        </button>
                        <button type="button" class="payment-tab-btn" onclick="switchPaymentTab('netbanking', this)">
                            <i class="fas fa-building-columns"></i> Net Banking
                        </button>
                        <button type="button" class="payment-tab-btn" onclick="switchPaymentTab('wallet', this)">
                            <i class="fas fa-wallet"></i> R-Wallet
                        </button>
                    </div>

                    <!-- Payment Content Area -->
                    <div class="payment-tab-content">
                        <!-- 1. UPI Tab (Default) -->
                        <div id="tab-upi" class="tab-pane">
                            <div class="upi-qr-container">
                                <h4 style="font-weight: 700; color: var(--wr-navy-900);">Scan Dynamic QR with Any UPI App</h4>
                                <p style="font-size: 0.82rem; color: var(--text-secondary);">
                                    Scan using Google Pay, PhonePe, Paytm, BHIM, or your mobile banking app
                                </p>

                                <div class="upi-qr-frame">
                                    <div id="paymentQR"></div>
                                    <div style="margin-top: 0.5rem; font-size: 0.75rem; font-weight: 700; color: var(--wr-crimson);">
                                        <i class="fas fa-stopwatch"></i> QR Expires in: <span id="qrTimer">04:59</span>
                                    </div>
                                </div>

                                <div class="upi-apps-icons">
                                    <span class="app-pill">GPay</span>
                                    <span class="app-pill">PhonePe</span>
                                    <span class="app-pill">Paytm</span>
                                    <span class="app-pill">BHIM UPI</span>
                                </div>

                                <form action="pamentconn.php" method="POST" style="width: 100%; margin-top: 1rem;">
                                    <input type="hidden" name="uname" value="<?php echo $passenger_name; ?>">
                                    <input type="hidden" name="pay1" value="<?php echo $fare_amount; ?>">
                                    <input type="hidden" name="text1" id="upiTxnRef" value="<?php echo rand(100000, 999999); ?>">

                                    <div class="form-group" style="margin-bottom: 1rem; text-align: left;">
                                        <label for="upiId"><i class="fas fa-at"></i> Or Enter UPI ID / VPA</label>
                                        <input type="text" id="upiId" class="form-control" placeholder="e.g. passenger@okaxis, mobile@ybl" value="<?php echo strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $passenger_name)); ?>@upi">
                                    </div>

                                    <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                                        <i class="fas fa-bolt"></i> Confirm & Authorize ₹<?php echo number_format($fare_amount, 2); ?>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- 2. Card Tab -->
                        <div id="tab-card" class="tab-pane" style="display:none;">
                            <form action="pamentconn.php" method="POST">
                                <input type="hidden" name="uname" value="<?php echo $passenger_name; ?>">
                                <input type="hidden" name="pay1" value="<?php echo $fare_amount; ?>">
                                <input type="hidden" name="text1" value="<?php echo rand(100000, 999999); ?>">

                                <div class="form-group" style="margin-bottom: 1rem;">
                                    <label><i class="fas fa-credit-card"></i> Card Number</label>
                                    <input type="text" class="form-control" placeholder="4532 •••• •••• 8821" maxlength="19" value="4532 9821 7721 8821">
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div class="form-group">
                                        <label><i class="fas fa-calendar"></i> Expiry (MM/YY)</label>
                                        <input type="text" class="form-control" placeholder="12/28" value="12/28">
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-shield"></i> CVV</label>
                                        <input type="password" class="form-control" placeholder="•••" maxlength="3" value="842">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 1.5rem;">
                                    <label><i class="fas fa-user"></i> Name on Card</label>
                                    <input type="text" class="form-control" value="<?php echo $passenger_name; ?>">
                                </div>

                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-lock"></i> Pay ₹<?php echo number_format($fare_amount, 2); ?> via Card
                                </button>
                            </form>
                        </div>

                        <!-- 3. Net Banking Tab -->
                        <div id="tab-netbanking" class="tab-pane" style="display:none;">
                            <form action="pamentconn.php" method="POST">
                                <input type="hidden" name="uname" value="<?php echo $passenger_name; ?>">
                                <input type="hidden" name="pay1" value="<?php echo $fare_amount; ?>">
                                <input type="hidden" name="text1" value="<?php echo rand(100000, 999999); ?>">

                                <div class="form-group" style="margin-bottom: 1.5rem;">
                                    <label><i class="fas fa-building-columns"></i> Popular Indian Banks</label>
                                    <select class="form-control" style="font-weight:600;">
                                        <option value="SBI">State Bank of India (SBI)</option>
                                        <option value="HDFC">HDFC Bank</option>
                                        <option value="ICICI">ICICI Bank</option>
                                        <option value="AXIS">Axis Bank</option>
                                        <option value="BOB">Bank of Baroda</option>
                                        <option value="PNB">Punjab National Bank</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-arrow-up-right-from-square"></i> Continue to Bank Portal
                                </button>
                            </form>
                        </div>

                        <!-- 4. R-Wallet Tab -->
                        <div id="tab-wallet" class="tab-pane" style="display:none;">
                            <form action="pamentconn.php" method="POST">
                                <input type="hidden" name="uname" value="<?php echo $passenger_name; ?>">
                                <input type="hidden" name="pay1" value="<?php echo $fare_amount; ?>">
                                <input type="hidden" name="text1" value="<?php echo rand(100000, 999999); ?>">

                                <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; margin-bottom: 1.5rem;">
                                    <div style="font-size: 0.8rem; color: #64748b;">Railway R-Wallet Balance</div>
                                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--wr-green);">₹350.00</div>
                                    <div style="font-size: 0.75rem; color: #059669; margin-top: 0.25rem;">
                                        <i class="fas fa-circle-check"></i> Sufficient balance available for this journey
                                    </div>
                                </div>

                                <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                                    <i class="fas fa-wallet"></i> 1-Click Pay ₹<?php echo number_format($fare_amount, 2); ?> via R-Wallet
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:1.5rem; font-size:0.82rem; color:#64748b;">
                    <a href="Teckit.php" style="color: var(--text-secondary); text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Back to Train Selection
                    </a>
                    <span><i class="fas fa-shield"></i> Safe & Secure Payment powered by CRIS</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="railway-footer">
        <div class="footer-bottom" style="margin-top:0;">
            &copy; <?php echo date('Y'); ?> Mumbai Suburban Railway • Western, Central & Harbour Lines • All Transactions Protected
        </div>
    </footer>

    <script src="java/modern-railway.js"></script>
    <script>
        function switchPaymentTab(tabName, btn) {
            document.querySelectorAll('.payment-tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            document.querySelectorAll('.tab-pane').forEach(p => p.style.display = 'none');
            const target = document.getElementById('tab-' + tabName);
            if (target) target.style.display = 'block';
        }

        generateTicketQR('paymentQR', 'UPI-PAYMENT-AMOUNT-<?php echo $fare_amount; ?>');

        let remaining = 300;
        const timerEl = document.getElementById('qrTimer');
        setInterval(() => {
            if (remaining > 0) {
                remaining--;
                const mins = String(Math.floor(remaining / 60)).padStart(2, '0');
                const secs = String(remaining % 60).padStart(2, '0');
                if (timerEl) timerEl.textContent = `${mins}:${secs}`;
            }
        }, 1000);
    </script>
</body>
</html>