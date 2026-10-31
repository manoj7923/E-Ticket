<?php
session_start();
require_once "db_conn.php";

$nfrom   = isset($_POST['data']) ? trim($_POST['data']) : '';
$eto     = isset($_POST['data1']) ? trim($_POST['data1']) : '';
$ndate   = isset($_POST['Date']) ? trim($_POST['Date']) : date('Y-m-d');
$tstatus = isset($_POST['single']) ? trim($_POST['single']) : 'Single';
$tusname = isset($_POST['uname1']) ? trim($_POST['uname1']) : ($_SESSION['name'] ?? 'Passenger');
$jclass  = isset($_POST['journey_class']) ? trim($_POST['journey_class']) : 'Second Class';

if (empty($nfrom)) {
    header("Location: home.php?error=Source station cannot be empty");
    exit();
}

if (empty($eto)) {
    header("Location: home.php?error=Destination station cannot be empty");
    exit();
}

if ($nfrom === $eto) {
    header("Location: home.php?error=Source and Destination stations cannot be the same");
    exit();
}

// Multi-Line Station Matrix for Backend Calculations
$stations_matrix = [
    // Western Line
    'Churchgate' => ['line' => 'WR', 'km' => 0.0], 'Marine Lines' => ['line' => 'WR', 'km' => 1.4],
    'Charni Road' => ['line' => 'WR', 'km' => 2.3], 'Grant Road' => ['line' => 'WR', 'km' => 3.7],
    'Mumbai Central' => ['line' => 'WR', 'km' => 4.7], 'Mahalaxmi' => ['line' => 'WR', 'km' => 6.0],
    'Lower Parel' => ['line' => 'WR', 'km' => 7.5], 'Prabhadevi' => ['line' => 'WR', 'km' => 8.8],
    'Dadar' => ['line' => 'WR', 'km' => 10.2], 'Dadar (WR)' => ['line' => 'WR', 'km' => 10.2],
    'Matunga Road' => ['line' => 'WR', 'km' => 11.4], 'Mahim Junction' => ['line' => 'WR', 'km' => 12.8],
    'Bandra' => ['line' => 'WR', 'km' => 14.8], 'Khar Road' => ['line' => 'WR', 'km' => 16.5],
    'Santacruz' => ['line' => 'WR', 'km' => 18.0], 'Vile Parle' => ['line' => 'WR', 'km' => 19.8],
    'Andheri' => ['line' => 'WR', 'km' => 21.8], 'Jogeshwari' => ['line' => 'WR', 'km' => 24.2],
    'Ram Mandir' => ['line' => 'WR', 'km' => 25.8], 'Goregaon' => ['line' => 'WR', 'km' => 27.0],
    'Malad' => ['line' => 'WR', 'km' => 29.8], 'Kandivali' => ['line' => 'WR', 'km' => 31.8],
    'Borivali' => ['line' => 'WR', 'km' => 34.2], 'Dahisar' => ['line' => 'WR', 'km' => 36.8],
    'Mira Road' => ['line' => 'WR', 'km' => 40.5], 'Bhayandar' => ['line' => 'WR', 'km' => 43.8],
    'Naigaon' => ['line' => 'WR', 'km' => 48.0], 'Vasai Road' => ['line' => 'WR', 'km' => 52.0],
    'Nala Sopara' => ['line' => 'WR', 'km' => 56.2], 'Virar' => ['line' => 'WR', 'km' => 60.0],
    'Palghar' => ['line' => 'WR', 'km' => 91.5], 'Boisar' => ['line' => 'WR', 'km' => 103.0],
    'Dahanu Road' => ['line' => 'WR', 'km' => 124.0],

    // Central Line
    'CSMT' => ['line' => 'CR', 'km' => 0.0], 'CSMT (Central)' => ['line' => 'CR', 'km' => 0.0],
    'Masjid' => ['line' => 'CR', 'km' => 1.5], 'Masjid (CR)' => ['line' => 'CR', 'km' => 1.5],
    'Sandhurst Road' => ['line' => 'CR', 'km' => 2.5], 'Sandhurst Road (CR)' => ['line' => 'CR', 'km' => 2.5],
    'Byculla' => ['line' => 'CR', 'km' => 4.0], 'Chinchpokli' => ['line' => 'CR', 'km' => 5.2],
    'Currey Road' => ['line' => 'CR', 'km' => 6.3], 'Parel' => ['line' => 'CR', 'km' => 7.5],
    'Dadar (CR)' => ['line' => 'CR', 'km' => 9.0], 'Matunga' => ['line' => 'CR', 'km' => 10.5],
    'Sion' => ['line' => 'CR', 'km' => 13.0], 'Kurla' => ['line' => 'CR', 'km' => 15.5],
    'Kurla (CR)' => ['line' => 'CR', 'km' => 15.5], 'Vidyavihar' => ['line' => 'CR', 'km' => 17.5],
    'Ghatkopar' => ['line' => 'CR', 'km' => 19.5], 'Vikhroli' => ['line' => 'CR', 'km' => 23.0],
    'Kanjurmarg' => ['line' => 'CR', 'km' => 25.0], 'Bhandup' => ['line' => 'CR', 'km' => 27.0],
    'Nahur' => ['line' => 'CR', 'km' => 29.0], 'Mulund' => ['line' => 'CR', 'km' => 31.0],
    'Thane' => ['line' => 'CR', 'km' => 34.0], 'Kalva' => ['line' => 'CR', 'km' => 36.5],
    'Mumbra' => ['line' => 'CR', 'km' => 40.0], 'Diva Junction' => ['line' => 'CR', 'km' => 43.0],
    'Kopar' => ['line' => 'CR', 'km' => 47.0], 'Dombivli' => ['line' => 'CR', 'km' => 48.5],
    'Thakurli' => ['line' => 'CR', 'km' => 50.5], 'Kalyan Junction' => ['line' => 'CR', 'km' => 54.0],
    'Titwala' => ['line' => 'CR', 'km' => 67.0], 'Asangaon' => ['line' => 'CR', 'km' => 85.0],
    'Kasara' => ['line' => 'CR', 'km' => 121.0], 'Ambernath' => ['line' => 'CR', 'km' => 60.0],
    'Badlapur' => ['line' => 'CR', 'km' => 68.0], 'Karjat' => ['line' => 'CR', 'km' => 100.0],

    // Harbour Line
    'CSMT (Harbour)' => ['line' => 'HR', 'km' => 0.0], 'Dockyard Road' => ['line' => 'HR', 'km' => 3.8],
    'Reay Road' => ['line' => 'HR', 'km' => 4.9], 'Cotton Green' => ['line' => 'HR', 'km' => 5.9],
    'Sewri' => ['line' => 'HR', 'km' => 7.2], 'Vadala Road' => ['line' => 'HR', 'km' => 9.3],
    'GTB Nagar' => ['line' => 'HR', 'km' => 11.5], 'Chunabhatti' => ['line' => 'HR', 'km' => 13.0],
    'Kurla (Harbour)' => ['line' => 'HR', 'km' => 15.0], 'Tilak Nagar' => ['line' => 'HR', 'km' => 17.0],
    'Chembur' => ['line' => 'HR', 'km' => 18.5], 'Govandi' => ['line' => 'HR', 'km' => 20.0],
    'Mankhurd' => ['line' => 'HR', 'km' => 22.0], 'Vashi' => ['line' => 'HR', 'km' => 29.0],
    'Sanpada' => ['line' => 'HR', 'km' => 31.0], 'Juinagar' => ['line' => 'HR', 'km' => 33.0],
    'Nerul' => ['line' => 'HR', 'km' => 35.5], 'Seawoods-Darave' => ['line' => 'HR', 'km' => 38.0],
    'Belapur CBD' => ['line' => 'HR', 'km' => 41.0], 'Kharghar' => ['line' => 'HR', 'km' => 44.5],
    'Mansarovar' => ['line' => 'HR', 'km' => 47.5], 'Khandeshwar' => ['line' => 'HR', 'km' => 50.0],
    'Panvel' => ['line' => 'HR', 'km' => 53.0]
];

$st_from = $stations_matrix[$nfrom] ?? ['line' => 'WR', 'km' => 0.0];
$st_to   = $stations_matrix[$eto]   ?? ['line' => 'WR', 'km' => 34.2];

$dist = 0;
$interchange = 'Direct Non-Stop Journey';
$net_line = 'Western Line';

if ($st_from['line'] === $st_to['line']) {
    $dist = abs($st_to['km'] - $st_from['km']);
    $line_map = ['WR' => 'Western Line', 'CR' => 'Central Main Line', 'HR' => 'Harbour Line'];
    $net_line = $line_map[$st_from['line']] ?? 'Suburban Line';
} else {
    // Cross-line transfer calculation
    if (($st_from['line'] === 'WR' && $st_to['line'] === 'CR') || ($st_from['line'] === 'CR' && $st_to['line'] === 'WR')) {
        $interchange = 'Interchange at Dadar (WR ⇄ CR)';
        $net_line = 'Western + Central Lines';
        $p1 = abs(($st_from['line'] === 'WR' ? $st_from['km'] : $st_to['km']) - 10.2);
        $p2 = abs(($st_from['line'] === 'CR' ? $st_from['km'] : $st_to['km']) - 9.0);
        $dist = $p1 + $p2;
    } else if (($st_from['line'] === 'CR' && $st_to['line'] === 'HR') || ($st_from['line'] === 'HR' && $st_to['line'] === 'CR')) {
        $interchange = 'Interchange at Kurla (CR ⇄ HR)';
        $net_line = 'Central + Harbour Lines';
        $p1 = abs(($st_from['line'] === 'CR' ? $st_from['km'] : $st_to['km']) - 15.5);
        $p2 = abs(($st_from['line'] === 'HR' ? $st_from['km'] : $st_to['km']) - 15.0);
        $dist = $p1 + $p2;
    } else {
        $interchange = 'Interchange via Dadar / Wadala';
        $net_line = 'Western + Harbour Lines';
        $dist = abs($st_from['km'] - 14.8) + abs($st_to['km'] - 9.3) + 6.0;
    }
}

// Calculate suburban fare
$base_fare = 5;
if ($dist > 10 && $dist <= 20) $base_fare = 10;
elseif ($dist > 20 && $dist <= 40) $base_fare = 15;
elseif ($dist > 40 && $dist <= 55) $base_fare = 20;
elseif ($dist > 55 && $dist <= 75) $base_fare = 25;
elseif ($dist > 75 && $dist <= 95) $base_fare = 30;
elseif ($dist > 95) $base_fare = 35;

if ($jclass === 'First Class') {
    $single_fare = max(50, round(($base_fare * 5.5) / 5) * 5);
} elseif ($jclass === 'AC Local') {
    $single_fare = max(65, round(($base_fare * 6.8) / 5) * 5);
} else {
    $single_fare = $base_fare;
}
$return_fare = $single_fare * 2;

// Save state in session
$_SESSION['last_from'] = $nfrom;
$_SESSION['last_to'] = $eto;
$_SESSION['last_date'] = $ndate;
$_SESSION['last_status'] = $tstatus;
$_SESSION['last_class'] = $jclass;
$_SESSION['last_line'] = $net_line;
$_SESSION['last_interchange'] = $interchange;
$_SESSION['last_dist'] = round($dist, 1);

// Update reference fare in sstatus
$conn->query("UPDATE sstatus SET ssingle='$single_fare', RReturn='$return_fare' WHERE id=1");

$safe_from   = addslashes($nfrom);
$safe_to     = addslashes($eto);
$safe_date   = addslashes($ndate);
$safe_status = addslashes($tstatus);
$safe_uname  = addslashes($tusname);
$safe_class  = addslashes($jclass);
$safe_line   = addslashes($net_line);
$safe_ic     = addslashes($interchange);

$sql = "INSERT INTO ordertick (ffrom, fto, fdate, fstatus, username, journey_class, network_line, interchange) 
        VALUES ('$safe_from', '$safe_to', '$safe_date', '$safe_status', '$safe_uname', '$safe_class', '$safe_line', '$safe_ic')";

if ($conn->query($sql)) {
    header("Location: Teckit.php");
    exit();
} else {
    // Fallback if table had old columns
    $fallback_sql = "INSERT INTO ordertick (ffrom, fto, fdate, fstatus, username) 
                    VALUES ('$safe_from', '$safe_to', '$safe_date', '$safe_status', '$safe_uname')";
    if ($conn->query($fallback_sql)) {
        header("Location: Teckit.php");
        exit();
    } else {
        echo "Error saving order: " . $conn->error;
    }
}
?>
