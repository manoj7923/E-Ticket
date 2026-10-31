<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

$passenger_name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : htmlspecialchars($_SESSION['user_name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Mumbai Suburban E-Ticket System | WR • CR • HR Multi-Line</title>
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
                    <p>UTS Suburban E-Ticketing • WR • CR • HR</p>
                </div>
            </a>

            <nav class="header-nav">
                <a href="home.php" class="nav-link"><i class="fas fa-train"></i> Book Ticket</a>
                <a href="trainteckit.php" class="nav-link"><i class="fas fa-ticket-simple"></i> My Ticket</a>
                <a href="Cencel Teckit.php" class="nav-link"><i class="fas fa-ban"></i> Cancel Ticket</a>
                <a href="About.php" class="nav-link active"><i class="fas fa-circle-info"></i> About Network</a>
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
            <a href="trainteckit.php" class="nav-link"><i class="fas fa-ticket-simple"></i> View Current Ticket</a>
            <a href="Cencel Teckit.php" class="nav-link"><i class="fas fa-ban"></i> Cancel Ticket</a>
            <a href="About.php" class="nav-link active"><i class="fas fa-circle-info"></i> About Route & Network</a>
            <a href="Contect.php" class="nav-link"><i class="fas fa-headset"></i> Passenger Grievance</a>
            <a href="logout.php" class="btn-danger" style="margin-top:2rem;"><i class="fas fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <!-- Main Container -->
    <main class="main-wrapper">
        <div class="glass-card" style="margin-bottom: 2rem;">
            <div class="glass-card-header">
                <h2><i class="fas fa-circle-info"></i> Mumbai Suburban Railway E-Ticket Portal</h2>
                <span class="badge badge-success"><i class="fas fa-network-wired"></i> Western • Central • Harbour Corridors</span>
            </div>

            <div class="glass-card-body">
                <!-- Platform Vision & Highlights -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: center; margin-bottom: 2.5rem;">
                    <div>
                        <div class="badge badge-info" style="margin-bottom: 0.5rem;">Project Heritage & Vision</div>
                        <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--wr-navy-900); margin-bottom: 1rem; line-height: 1.3;">
                            Empowering 7.5+ Million Suburban Commuters with Paperless E-Ticketing
                        </h3>
                        <p style="color: var(--text-secondary); margin-bottom: 1rem; line-height: 1.6;">
                            This platform is a comprehensive suburban transit booking system inspired by Indian Railways CRIS UTS (Unreserved Ticketing System) and IRCTC. It was originally architected and developed by <strong>Manoj Gupta</strong> as a flagship college project to modernize ticketing across the Mumbai suburban rail network.
                        </p>
                        <p style="color: var(--text-secondary); line-height: 1.6;">
                            The platform connects all three vital lifelines of Mumbai—the <strong>Western Line</strong>, <strong>Central Main Line</strong>, and <strong>Harbour Line</strong>—with seamless interchange routing at Dadar and Kurla, interactive transit map route booking, and strict <strong>12-hour ticket validity enforcement</strong> with real-time countdown meters.
                        </p>
                    </div>

                    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #bbf7d0; border-radius: var(--radius-xl); padding: 1.75rem;">
                        <h4 style="font-size: 1.1rem; font-weight: 700; color: #166534; margin-bottom: 1rem; display:flex; align-items:center; gap:0.5rem;">
                            <i class="fas fa-award"></i> Core Platform Features
                        </h4>
                        <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem; color: #14532d;">
                            <li><i class="fas fa-check-circle" style="color:var(--wr-green);"></i> <strong>Unified 3-Line Network:</strong> 89+ stations spanning WR (124 km), CR (121 km), and HR (53 km).</li>
                            <li><i class="fas fa-check-circle" style="color:var(--wr-green);"></i> <strong>Interactive Transit Map:</strong> Point-and-click route booking with visual SVG track tracing and line filters.</li>
                            <li><i class="fas fa-check-circle" style="color:var(--wr-green);"></i> <strong>12-Hour Ticket Validity:</strong> Strict 12-hour travel countdown timer and progress meter on every confirmed ticket.</li>
                            <li><i class="fas fa-check-circle" style="color:var(--wr-green);"></i> <strong>Interchange Support:</strong> Automatic transfer routing via Dadar (WR ⇄ CR) and Kurla (CR ⇄ HR).</li>
                            <li><i class="fas fa-check-circle" style="color:var(--wr-green);"></i> <strong>Dynamic Fare Calculation:</strong> Accurate distance-tiered suburban fare table in Indian Rupees.</li>
                            <li><i class="fas fa-check-circle" style="color:var(--wr-green);"></i> <strong>Cryptographic QR Code:</strong> Sharp anti-fraud boarding pass ready for instant TTE verification.</li>
                        </ul>
                    </div>
                </div>

                <!-- Mumbai 3-Line Suburban Network Breakdown -->
                <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--wr-navy-900); margin-bottom: 1.25rem;">
                    <i class="fas fa-train-subway" style="color:var(--wr-blue-600);"></i> Mumbai Suburban Rail Corridors Overview
                </h3>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
                    <!-- Western Line Card -->
                    <div style="background: #ffffff; border: 2px solid #bae6fd; border-radius: var(--radius-lg); padding: 1.5rem; position: relative;">
                        <span class="badge badge-wr" style="margin-bottom: 0.75rem;">Western Line (WR)</span>
                        <h4 style="font-weight: 800; color: #0284c7; font-size: 1.1rem;">Churchgate ➔ Dahanu Road</h4>
                        <div style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem; margin-bottom: 0.75rem;">
                            <strong>Total Distance:</strong> 124 km • <strong>Key Hubs:</strong> Churchgate, Mumbai Central, Dadar, Bandra, Andheri, Borivali, Vasai, Virar, Palghar, Dahanu.
                        </div>
                        <p style="font-size: 0.82rem; color: #334155; line-height: 1.5;">
                            Runs parallel to the Arabian Sea coastline. Connects South Mumbai financial center to commercial hubs and the fast-growing Northern Palghar district.
                        </p>
                    </div>

                    <!-- Central Line Card -->
                    <div style="background: #ffffff; border: 2px solid #fecaca; border-radius: var(--radius-lg); padding: 1.5rem; position: relative;">
                        <span class="badge badge-cr" style="margin-bottom: 0.75rem;">Central Main Line (CR)</span>
                        <h4 style="font-weight: 800; color: #b91c1c; font-size: 1.1rem;">CSMT ➔ Kalyan / Kasara / Karjat</h4>
                        <div style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem; margin-bottom: 0.75rem;">
                            <strong>Total Distance:</strong> 121 km • <strong>Key Hubs:</strong> CSMT, Byculla, Dadar, Kurla, Ghatkopar, Bhandup, Thane, Dombivli, Kalyan, Kasara, Karjat.
                        </div>
                        <p style="font-size: 0.82rem; color: #334155; line-height: 1.5;">
                            The historic backbone of Mumbai commuting. Branches at Kalyan into two north-east and south-east corridors towards Kasara (Igatpuri) and Karjat (Pune).
                        </p>
                    </div>

                    <!-- Harbour Line Card -->
                    <div style="background: #ffffff; border: 2px solid #99f6e4; border-radius: var(--radius-lg); padding: 1.5rem; position: relative;">
                        <span class="badge badge-hr" style="margin-bottom: 0.75rem;">Harbour Line (HR)</span>
                        <h4 style="font-weight: 800; color: #0f766e; font-size: 1.1rem;">CSMT ➔ Panvel & Bandra/Andheri</h4>
                        <div style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem; margin-bottom: 0.75rem;">
                            <strong>Total Distance:</strong> 53 km • <strong>Key Hubs:</strong> CSMT, Dockyard Rd, Vadala Rd, Kurla, Chembur, Vashi, Nerul, Belapur, Kharghar, Panvel.
                        </div>
                        <p style="font-size: 0.82rem; color: #334155; line-height: 1.5;">
                            Connects Mumbai Island to Navi Mumbai across the Thane Creek, with an important branch connecting Vadala Road to Bandra and Goregaon on WR.
                        </p>
                    </div>
                </div>

                <!-- Interchanges & 12-Hour Validity Feature Callout -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                    <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.25rem;">
                        <h4 style="font-size: 1rem; font-weight: 700; color: var(--wr-navy-900); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span class="badge badge-interchange"><i class="fas fa-shuffle"></i> Interchanges</span> Major Network Junctions
                        </h4>
                        <ul style="font-size: 0.85rem; color: #475569; padding-left: 1.2rem; line-height: 1.6;">
                            <li><strong>Dadar Junction:</strong> Primary interchange connecting Western Line and Central Main Line.</li>
                            <li><strong>Kurla Junction:</strong> Primary interchange connecting Central Main Line and Harbour Line.</li>
                            <li><strong>CSMT & Sandhurst Road:</strong> Dual-terminal and transfer between Central and Harbour lines.</li>
                            <li><strong>Wadala Road & Bandra:</strong> Connector bridging Harbour Line to Western Line.</li>
                        </ul>
                    </div>

                    <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: var(--radius-lg); padding: 1.25rem;">
                        <h4 style="font-size: 1rem; font-weight: 700; color: #92400e; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span class="badge-12h"><i class="fas fa-stopwatch"></i> 12-Hour Validity</span> Ticket Validity Policy
                        </h4>
                        <p style="font-size: 0.85rem; color: #78350f; line-height: 1.6;">
                            Under suburban railway rules, unreserved EMU single and return tickets carry an active validity window of <strong>12 hours</strong> from the exact moment of issuance. The live countdown timer tracks the validity in real time to guarantee peace of mind for commuters and railway checking staff.
                        </p>
                    </div>
                </div>

                <!-- Developer Attribution Badge -->
                <div style="background: linear-gradient(135deg, #0b2545 0%, #172554 100%); color: #ffffff; border-radius: var(--radius-lg); padding: 1.5rem; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
                    <div>
                        <div style="font-size: 0.78rem; text-transform: uppercase; color: var(--wr-saffron); font-weight: 700; letter-spacing: 0.05em;">Developer & Project Creator</div>
                        <div style="font-size: 1.35rem; font-weight: 800;">Manoj Gupta</div>
                        <div style="font-size: 0.82rem; color: #cbd5e1; margin-top: 0.2rem;">
                            Original College Project • Advanced into Full-Scale Multi-Line Mumbai Transit Platform
                        </div>
                    </div>
                    <div style="display: flex; gap: 0.75rem;">
                        <a href="home.php" class="btn-primary" style="background: var(--wr-saffron); color: #000000; font-weight: 800; width: auto;">
                            <i class="fas fa-train"></i> Book Journey
                        </a>
                        <a href="https://github.com/manoj7923/E-Ticket" target="_blank" rel="noopener noreferrer" class="btn-secondary" style="background: rgba(255,255,255,0.15); color: #ffffff; border-color: rgba(255,255,255,0.3); width: auto;">
                            <i class="fab fa-github"></i> View GitHub Repo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="railway-footer">
        <div class="footer-bottom" style="margin-top:0;">
            &copy; <?php echo date('Y'); ?> Mumbai Suburban Railway • Western, Central & Harbour Lines • Designed & Built by Manoj Gupta
        </div>
    </footer>

    <script src="java/modern-railway.js"></script>
</body>
</html>