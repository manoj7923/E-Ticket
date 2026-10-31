<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

require_once "db_conn.php";
$passenger_name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : htmlspecialchars($_SESSION['user_name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mumbai Suburban E-Ticket | Western, Central & Harbour Lines</title>
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

            <!-- Desktop Nav Links -->
            <nav class="header-nav">
                <a href="home.php" class="nav-link active"><i class="fas fa-train"></i> Book Ticket</a>
                <a href="#mapBookingSection" class="nav-link" onclick="scrollToMap()"><i class="fas fa-map-location-dot"></i> Network Map</a>
                <a href="trainteckit.php" class="nav-link"><i class="fas fa-ticket-simple"></i> My Ticket</a>
                <a href="Cencel Teckit.php" class="nav-link"><i class="fas fa-ban"></i> Cancel Ticket</a>
                <a href="About.php" class="nav-link"><i class="fas fa-circle-info"></i> Network Info</a>
                <a href="Contect.php" class="nav-link"><i class="fas fa-headset"></i> Rail Madad</a>
            </nav>

            <!-- User Status & Clock -->
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

                <a href="logout.php" class="btn-logout" title="Sign out of current session">
                    <i class="fas fa-power-off"></i> Logout
                </a>

                <button class="mobile-nav-toggle" onclick="toggleNavDrawer()" aria-label="Toggle navigation menu">
                    <i class="fas fa-bars"></i>
                </button>
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

        <div style="padding: 0.75rem 0; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); color:#94a3b8; font-size:0.85rem;">
            Passenger: <strong style="color:#ffffff;"><?php echo $passenger_name; ?></strong>
        </div>

        <div class="mobile-drawer-links">
            <a href="home.php" class="nav-link active"><i class="fas fa-train"></i> Book Ticket</a>
            <a href="#mapBookingSection" onclick="scrollToMap(); closeNavDrawer();" class="nav-link"><i class="fas fa-map-location-dot"></i> Interactive Map</a>
            <a href="trainteckit.php" class="nav-link"><i class="fas fa-ticket-simple"></i> View Current Ticket</a>
            <a href="Cencel Teckit.php" class="nav-link"><i class="fas fa-ban"></i> Cancel Ticket</a>
            <a href="About.php" class="nav-link"><i class="fas fa-circle-info"></i> All 3 Lines Network</a>
            <a href="Contect.php" class="nav-link"><i class="fas fa-headset"></i> Passenger Grievance</a>
            <div style="margin-top: 2rem;">
                <a href="logout.php" class="btn-danger" style="width: 100%;"><i class="fas fa-arrow-right-from-bracket"></i> Logout</a>
            </div>
        </div>
    </div>

    <!-- Official Railway Ticker -->
    <div class="railway-ticker">
        <span class="ticker-label"><i class="fas fa-bullhorn"></i> MUMBAI LOCAL LIVE</span>
        <div class="ticker-content">
            Suburban Services Running across Western Line (Churchgate - Dahanu), Central Line (CSMT - Kalyan - Kasara/Karjat), and Harbour Line (CSMT - Panvel) • Confirmed tickets carry 12-Hour Validity across all lines • Transfers available at Dadar (WR ⇄ CR) and Kurla (CR ⇄ HR).
        </div>
    </div>

    <!-- Main Content Area -->
    <main class="main-wrapper">

        <!-- Line Status Pills -->
        <div style="display:flex; flex-wrap:wrap; gap:0.75rem; margin-bottom:1.5rem; justify-content:center;">
            <span class="badge badge-wr" style="padding:0.4rem 0.85rem; font-size:0.82rem;">
                <i class="fas fa-circle-check"></i> Western Line (37 Stations)
            </span>
            <span class="badge badge-cr" style="padding:0.4rem 0.85rem; font-size:0.82rem;">
                <i class="fas fa-circle-check"></i> Central Main Line (32 Stations)
            </span>
            <span class="badge badge-hr" style="padding:0.4rem 0.85rem; font-size:0.82rem;">
                <i class="fas fa-circle-check"></i> Harbour Line (25 Stations)
            </span>
            <span class="badge-12h" style="padding:0.4rem 0.85rem;">
                <i class="fas fa-stopwatch"></i> 12-Hour Ticket Validity
            </span>
        </div>

        <!-- ==========================================================
             INTERACTIVE MAP BOOKING SECTION
             ========================================================== -->
        <section id="mapBookingSection" class="transit-map-wrapper">
            <div class="transit-map-toolbar">
                <div style="display:flex; align-items:center; gap:0.5rem;">
                    <span style="font-weight:800; color:var(--wr-navy-900); font-size:0.95rem;">
                        <i class="fas fa-map-location-dot" style="color:var(--wr-blue-600);"></i> Interactive Mumbai Suburban Transit Map
                    </span>
                    <span style="font-size:0.75rem; color:#64748b;">(Click Origin ➔ Click Destination)</span>
                </div>

                <!-- Line Filters -->
                <div class="map-line-filters">
                    <button type="button" class="map-filter-btn active" data-line="ALL" onclick="filterMapLine('ALL')">All Networks</button>
                    <button type="button" class="map-filter-btn" data-line="WR" onclick="filterMapLine('WR')">Western (WR)</button>
                    <button type="button" class="map-filter-btn" data-line="CR" onclick="filterMapLine('CR')">Central (CR)</button>
                    <button type="button" class="map-filter-btn" data-line="HR" onclick="filterMapLine('HR')">Harbour (HR)</button>
                    <button type="button" class="btn-secondary" style="padding:0.25rem 0.65rem; font-size:0.75rem;" onclick="clearMapSelection()">
                        <i class="fas fa-rotate-left"></i> Reset
                    </button>
                </div>
            </div>

            <!-- Map SVG Canvas -->
            <div class="transit-map-canvas-box">
                <div id="transitMapContainer" style="width:100%; max-width:900px;"></div>
            </div>

            <!-- Floating Route HUD Card (Updated dynamically on click) -->
            <div id="mapRouteHUD" class="map-route-hud-card"></div>
        </section>

        <!-- ==========================================================
             FORM SEARCH & JOURNEY DETAILS CARD
             ========================================================== -->
        <div class="glass-card">
            <div class="glass-card-header">
                <h2><i class="fas fa-ticket"></i> Journey Planner & Instant Booking</h2>
                <span class="badge badge-success"><i class="fas fa-clock"></i> 12 Hours Validity On Confirmation</span>
            </div>

            <div class="glass-card-body">
                <form action="homeconection.php" method="POST" id="journeySearchForm">
                    <input type="hidden" name="uname1" value="<?php echo $passenger_name; ?>">

                    <!-- Origin / Destination Station Pickers -->
                    <div class="booking-grid">
                        <div class="station-input-group">
                            <label for="stan1"><i class="fas fa-location-dot" style="color:var(--wr-green);"></i> Source Station (Origin)</label>
                            <div class="station-input-box">
                                <i class="fas fa-train-subway station-icon"></i>
                                <input list="allStationsDatalist" id="stan1" name="data" placeholder="Type or select station (e.g. Churchgate / CSMT / Thane)" required autocomplete="off" value="Churchgate">
                            </div>
                        </div>

                        <button type="button" class="swap-btn" onclick="swapStations()" title="Swap Source and Destination">
                            <i class="fas fa-arrow-right-arrow-left"></i>
                        </button>

                        <div class="station-input-group">
                            <label for="To"><i class="fas fa-location-crosshairs" style="color:var(--wr-crimson);"></i> Destination Station</label>
                            <div class="station-input-box">
                                <i class="fas fa-train-subway station-icon"></i>
                                <input list="allStationsDatalist" id="To" name="data1" placeholder="Type or select station (e.g. Borivali / Kalyan / Panvel)" required autocomplete="off" value="Borivali">
                            </div>
                        </div>
                    </div>

                    <!-- Comprehensive Multi-Line Stations Datalist -->
                    <datalist id="allStationsDatalist">
                        <!-- Western Line (Churchgate - Dahanu) -->
                        <option value="Churchgate">Churchgate [WR] (CCG)</option>
                        <option value="Marine Lines">Marine Lines [WR] (MEL)</option>
                        <option value="Charni Road">Charni Road [WR] (CYR)</option>
                        <option value="Grant Road">Grant Road [WR] (GTR)</option>
                        <option value="Mumbai Central">Mumbai Central [WR] (MMCT)</option>
                        <option value="Mahalaxmi">Mahalaxmi [WR] (MX)</option>
                        <option value="Lower Parel">Lower Parel [WR] (PL)</option>
                        <option value="Prabhadevi">Prabhadevi [WR - Interchange with Parel CR] (PBHD)</option>
                        <option value="Dadar (WR)">Dadar [WR - Interchange with Central Line] (DDR)</option>
                        <option value="Matunga Road">Matunga Road [WR] (MRU)</option>
                        <option value="Mahim Junction">Mahim Junction [WR - Interchange with Harbour Branch] (MM)</option>
                        <option value="Bandra">Bandra [WR - Interchange with Harbour Branch] (BA)</option>
                        <option value="Khar Road">Khar Road [WR] (KHAR)</option>
                        <option value="Santacruz">Santacruz [WR] (STC)</option>
                        <option value="Vile Parle">Vile Parle [WR] (VLP)</option>
                        <option value="Andheri">Andheri [WR - Interchange with Metro 1 & Harbour] (ADH)</option>
                        <option value="Jogeshwari">Jogeshwari [WR] (JOS)</option>
                        <option value="Ram Mandir">Ram Mandir [WR] (RMAR)</option>
                        <option value="Goregaon">Goregaon [WR - Harbour Branch Terminus] (GMN)</option>
                        <option value="Malad">Malad [WR] (MDD)</option>
                        <option value="Kandivali">Kandivali [WR] (KNDI)</option>
                        <option value="Borivali">Borivali [WR] (BVI)</option>
                        <option value="Dahisar">Dahisar [WR] (DIC)</option>
                        <option value="Mira Road">Mira Road [WR] (MIRA)</option>
                        <option value="Bhayandar">Bhayandar [WR] (BYR)</option>
                        <option value="Naigaon">Naigaon [WR] (NIG)</option>
                        <option value="Vasai Road">Vasai Road [WR - Link with CR Diva] (BSR)</option>
                        <option value="Nala Sopara">Nala Sopara [WR] (NSP)</option>
                        <option value="Virar">Virar [WR] (VR)</option>
                        <option value="Palghar">Palghar [WR] (PLG)</option>
                        <option value="Boisar">Boisar [WR] (BOR)</option>
                        <option value="Dahanu Road">Dahanu Road [WR] (DRD)</option>

                        <!-- Central Main Line (CSMT - Kalyan - Kasara/Karjat) -->
                        <option value="CSMT (Central)">CSMT [CR - Interchange with Harbour Line] (CSMT)</option>
                        <option value="Masjid (CR)">Masjid [CR] (MSD)</option>
                        <option value="Sandhurst Road (CR)">Sandhurst Road [CR - Interchange with Harbour] (SNRD)</option>
                        <option value="Byculla">Byculla [CR] (BY)</option>
                        <option value="Chinchpokli">Chinchpokli [CR] (CHG)</option>
                        <option value="Currey Road">Currey Road [CR] (CRD)</option>
                        <option value="Parel">Parel [CR - Interchange with Prabhadevi WR] (PR)</option>
                        <option value="Dadar (CR)">Dadar [CR - Interchange with Western Line] (DDR)</option>
                        <option value="Matunga">Matunga [CR] (MTN)</option>
                        <option value="Sion">Sion [CR] (SIN)</option>
                        <option value="Kurla (CR)">Kurla [CR - Interchange with Harbour Line] (CLA)</option>
                        <option value="Vidyavihar">Vidyavihar [CR] (VVH)</option>
                        <option value="Ghatkopar">Ghatkopar [CR - Interchange with Metro 1] (GC)</option>
                        <option value="Vikhroli">Vikhroli [CR] (VK)</option>
                        <option value="Kanjurmarg">Kanjurmarg [CR] (KJMG)</option>
                        <option value="Bhandup">Bhandup [CR] (BND)</option>
                        <option value="Nahur">Nahur [CR] (NHU)</option>
                        <option value="Mulund">Mulund [CR] (MLND)</option>
                        <option value="Thane">Thane [CR - Interchange with Trans-Harbour] (TNA)</option>
                        <option value="Kalva">Kalva [CR] (KLVA)</option>
                        <option value="Mumbra">Mumbra [CR] (MBQ)</option>
                        <option value="Diva Junction">Diva Junction [CR - Link with Vasai WR] (DIVA)</option>
                        <option value="Kopar">Kopar [CR] (KOPR)</option>
                        <option value="Dombivli">Dombivli [CR] (DI)</option>
                        <option value="Thakurli">Thakurli [CR] (THK)</option>
                        <option value="Kalyan Junction">Kalyan Junction [CR] (KYN)</option>
                        <option value="Titwala">Titwala [CR] (TLA)</option>
                        <option value="Asangaon">Asangaon [CR] (ASO)</option>
                        <option value="Kasara">Kasara [CR] (KSRA)</option>
                        <option value="Ambernath">Ambernath [CR] (ABH)</option>
                        <option value="Badlapur">Badlapur [CR] (BUD)</option>
                        <option value="Karjat">Karjat [CR] (KJT)</option>

                        <!-- Harbour Line (CSMT - Panvel) -->
                        <option value="CSMT (Harbour)">CSMT [HR - Interchange with Central Line] (CSMT)</option>
                        <option value="Dockyard Road">Dockyard Road [HR] (DKRD)</option>
                        <option value="Reay Road">Reay Road [HR] (RRD)</option>
                        <option value="Cotton Green">Cotton Green [HR] (CTGN)</option>
                        <option value="Sewri">Sewri [HR] (SVE)</option>
                        <option value="Vadala Road">Vadala Road [HR - Interchange with Bandra/Andheri Branch] (VDLR)</option>
                        <option value="GTB Nagar">GTB Nagar [HR] (GTBN)</option>
                        <option value="Chunabhatti">Chunabhatti [HR] (CHF)</option>
                        <option value="Kurla (Harbour)">Kurla [HR - Interchange with Central Line] (CLA)</option>
                        <option value="Tilak Nagar">Tilak Nagar [HR] (TKNG)</option>
                        <option value="Chembur">Chembur [HR - Interchange with Monorail] (CMBR)</option>
                        <option value="Govandi">Govandi [HR] (GV)</option>
                        <option value="Mankhurd">Mankhurd [HR] (MNKD)</option>
                        <option value="Vashi">Vashi [HR - Navi Mumbai / Trans-Harbour] (VSH)</option>
                        <option value="Sanpada">Sanpada [HR] (SNCR)</option>
                        <option value="Juinagar">Juinagar [HR] (JNJ)</option>
                        <option value="Nerul">Nerul [HR] (NEU)</option>
                        <option value="Seawoods-Darave">Seawoods-Darave [HR] (SWDV)</option>
                        <option value="Belapur CBD">Belapur CBD [HR] (BEPR)</option>
                        <option value="Kharghar">Kharghar [HR] (KHAG)</option>
                        <option value="Mansarovar">Mansarovar [HR] (MANR)</option>
                        <option value="Khandeshwar">Khandeshwar [HR] (KNDS)</option>
                        <option value="Panvel">Panvel [HR - Terminus & Konkan Railway] (PNVL)</option>
                    </datalist>

                    <!-- Additional Options: Class, Trip Type, Date, Time -->
                    <div class="booking-options-grid">
                        <div class="form-group">
                            <label for="journeyClass"><i class="fas fa-couch"></i> Travel Class</label>
                            <select id="journeyClass" name="journey_class" class="form-control" onchange="updateLiveFarePreview()">
                                <option value="Second Class">Second Class (II Ordinary)</option>
                                <option value="First Class">First Class (FC)</option>
                                <option value="AC Local">AC Local EMU (Air Conditioned)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-repeat"></i> Journey Type</label>
                            <div class="trip-type-segmented">
                                <label style="flex:1; margin:0; cursor:pointer;">
                                    <input type="radio" name="tripType" value="Single" checked style="display:none;" onchange="document.getElementById('singleInput').value='Single'; updateLiveFarePreview();">
                                    <span class="trip-type-btn active" id="btnSingle" onclick="setTripType('Single', this)">Single Journey</span>
                                </label>
                                <label style="flex:1; margin:0; cursor:pointer;">
                                    <input type="radio" name="tripType" value="Return" style="display:none;" onchange="document.getElementById('singleInput').value='Return'; updateLiveFarePreview();">
                                    <span class="trip-type-btn" id="btnReturn" onclick="setTripType('Return', this)">Return Journey</span>
                                </label>
                            </div>
                            <input type="hidden" name="single" id="singleInput" value="Single">
                        </div>

                        <div class="form-group">
                            <label for="travelDate"><i class="fas fa-calendar-day"></i> Journey Date</label>
                            <input type="date" id="travelDate" name="Date" class="form-control" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="travelTime"><i class="fas fa-clock"></i> Preferred Time</label>
                            <input type="time" id="travelTime" name="travel_time" class="form-control" value="<?php echo date('H:i'); ?>" required>
                        </div>
                    </div>

                    <!-- Dynamic Live Fare Estimator Banner -->
                    <div class="fare-estimate-banner">
                        <div>
                            <div class="fare-info-title"><i class="fas fa-calculator"></i> Estimated Suburban Fare (CRIS UTS Matrix)</div>
                            <div class="fare-info-details" id="routeSummary">Churchgate ➔ Borivali (Second Class)</div>
                            <div style="font-size: 0.8rem; color: #64748b; margin-top: 0.2rem;">
                                Approximate Distance: <strong id="journeyDistance">34.2 km</strong> • 
                                <span class="badge-12h" style="padding:0.2rem 0.6rem; font-size:0.75rem;"><i class="fas fa-clock"></i> Valid for 12 Hours</span>
                            </div>
                        </div>
                        <div class="fare-amount-display">
                            <span class="fare-currency">₹</span>
                            <span class="fare-number" id="fareAmount">15</span>
                        </div>
                    </div>

                    <!-- Submission & Reset Buttons -->
                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem;">
                        <button type="reset" class="btn-secondary" onclick="setTimeout(updateLiveFarePreview, 50)">
                            <i class="fas fa-rotate-left"></i> Reset Fields
                        </button>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-train"></i> Find Local Trains & Proceed
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Professional Railway Footer -->
    <footer class="railway-footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h4>Mumbai Suburban Railway Ticketing Portal</h4>
                <p style="font-size: 0.82rem; color: #64748b; margin-top: 0.25rem;">
                    Center for Railway Information Systems (CRIS) • Western, Central & Harbour Lines
                </p>
            </div>
            <div class="footer-links">
                <a href="home.php">Book</a>
                <a href="#mapBookingSection" onclick="scrollToMap()">Transit Map</a>
                <a href="trainteckit.php">My Tickets</a>
                <a href="Cencel Teckit.php">Cancel Ticket</a>
                <a href="About.php">Network Details</a>
                <a href="Contect.php">Rail Madad Support</a>
                <a href="index1.php">Admin</a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; <?php echo date('Y'); ?> E-Ticket System For Local Train • Western, Central & Harbour Divisions • Designed & Developed by Manoj Gupta
        </div>
    </footer>

    <script src="java/modern-railway.js"></script>
    <script>
        function setTripType(type, btn) {
            document.querySelectorAll('.trip-type-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('singleInput').value = type;
            updateLiveFarePreview();
        }

        function scrollToMap() {
            const el = document.getElementById('mapBookingSection');
            if (el) el.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
