<?php
/**
 * E-Ticket Database Connection & Auto-Migration Layer
 * Resilient multi-mode connector: Supports MySQL (XAMPP/Cloud/Docker)
 * with graceful SQLite fallback if MySQL daemon is offline.
 * Supports Western, Central, and Harbour lines with 12-hour ticket validity.
 */

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if (!defined('DB_CONFIG_INITIALIZED')) {
    define('DB_CONFIG_INITIALIZED', true);

    $sname    = getenv('DB_HOST') ?: '127.0.0.1';
    $unmae    = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASSWORD') ?: (getenv('DB_PASS') ?: '');
    $db_name  = getenv('DB_NAME') ?: 'test';
    $db_port  = (int)(getenv('DB_PORT') ?: 3306);

    $sqlite_file = __DIR__ . '/db/e_ticket.sqlite';

    $conn = null;
    $use_sqlite = false;

    // 1. Try MySQL Connection
    if (extension_loaded('mysqli')) {
        mysqli_report(MYSQLI_REPORT_OFF);
        $conn = @mysqli_connect($sname, $unmae, $password, $db_name, $db_port);
        
        if (!$conn && mysqli_connect_errno() === 1049) {
            $root_conn = @mysqli_connect($sname, $unmae, $password, '', $db_port);
            if ($root_conn) {
                @mysqli_query($root_conn, "CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                @mysqli_close($root_conn);
                $conn = @mysqli_connect($sname, $unmae, $password, $db_name, $db_port);
            }
        }
    }

    // 2. Auto-migration if MySQL is active
    if ($conn && !$conn->connect_error) {
        $check = @$conn->query("SHOW TABLES LIKE 'booking'");
        if ($check && $check->num_rows === 0) {
            $schemaFile = __DIR__ . '/db/schema.sql';
            if (file_exists($schemaFile)) {
                $sql = file_get_contents($schemaFile);
                @$conn->multi_query($sql);
                while (@$conn->next_result()) { /* flush buffer */ }
            }
        }
    } else {
        // 3. Graceful SQLite Fallback for zero-dependency standalone execution
        $use_sqlite = true;

        if (!class_exists('ETicketSQLiteWrapper')) {
            class ETicketSQLiteResult {
                private $stmt;
                private $rows = [];
                private $cursor = 0;
                public $num_rows = 0;

                public function __construct($stmt) {
                    $this->stmt = $stmt;
                    if ($stmt) {
                        while ($row = $stmt->fetchArray(SQLITE3_ASSOC)) {
                            $this->rows[] = $row;
                        }
                        $this->num_rows = count($this->rows);
                    }
                }

                public function fetch_assoc() {
                    if ($this->cursor < $this->num_rows) {
                        return $this->rows[$this->cursor++];
                    }
                    return null;
                }
            }

            class ETicketSQLiteWrapper {
                private $db;
                public $error = '';
                public $insert_id = 0;

                public function __construct($filepath) {
                    $dir = dirname($filepath);
                    if (!is_dir($dir)) {
                        @mkdir($dir, 0777, true);
                    }
                    $isNew = !file_exists($filepath) || filesize($filepath) === 0;
                    $this->db = new SQLite3($filepath);
                    $this->db->busyTimeout(5000);

                    if ($isNew) {
                        $this->initSchema();
                    }
                }

                public function query($sql) {
                    $clean = trim($sql);
                    $clean = preg_replace('/AUTO_INCREMENT/i', 'AUTOINCREMENT', $clean);
                    $clean = preg_replace('/ENGINE=\w+/i', '', $clean);
                    $clean = preg_replace('/DEFAULT CHARSET=\w+/i', '', $clean);
                    $clean = preg_replace('/COLLATE=\w+/i', '', $clean);
                    $clean = preg_replace('/DATE_ADD\(NOW\(\),\s*INTERVAL\s*12\s*HOUR\)/i', "datetime('now', '+12 hours')", $clean);
                    $clean = str_replace('`', '"', $clean);

                    $isSelect = preg_match('/^\s*(SELECT|PRAGMA|SHOW)/i', $clean);

                    try {
                        if ($isSelect) {
                            $res = $this->db->query($clean);
                            return new ETicketSQLiteResult($res);
                        } else {
                            $exec = $this->db->exec($clean);
                            $this->insert_id = $this->db->lastInsertRowID();
                            return $exec;
                        }
                    } catch (Exception $e) {
                        $this->error = $e->getMessage();
                        return false;
                    }
                }

                public function close() {
                    return $this->db->close();
                }

                private function initSchema() {
                    $tables = [
                        "CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, user_name TEXT UNIQUE, password TEXT, name TEXT, email TEXT, mobile TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)",
                        "CREATE TABLE IF NOT EXISTS admin (id INTEGER PRIMARY KEY AUTOINCREMENT, user_name TEXT UNIQUE, password TEXT, name TEXT, role TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)",
                        "CREATE TABLE IF NOT EXISTS stations (id INTEGER PRIMARY KEY AUTOINCREMENT, code TEXT, name TEXT, line TEXT, distance_km REAL, is_interchange INTEGER DEFAULT 0, interchange_with TEXT)",
                        "CREATE TABLE IF NOT EXISTS trains (id INTEGER PRIMARY KEY AUTOINCREMENT, numbertrain TEXT, returnTno TEXT, ticketNo TEXT, train_name TEXT, line TEXT, train_type TEXT, source TEXT, destination TEXT, departure_time TEXT, arrival_time TEXT)",
                        "CREATE TABLE IF NOT EXISTS sstatus (id INTEGER PRIMARY KEY AUTOINCREMENT, ssingle REAL, RReturn REAL, first_class_single REAL, first_class_return REAL, ac_single REAL, ac_return REAL)",
                        "CREATE TABLE IF NOT EXISTS ordertick (id INTEGER PRIMARY KEY AUTOINCREMENT, ffrom TEXT, fto TEXT, fdate TEXT, fstatus TEXT, username TEXT, journey_class TEXT, network_line TEXT, interchange TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)",
                        "CREATE TABLE IF NOT EXISTS booking (id INTEGER PRIMARY KEY AUTOINCREMENT, tnom TEXT, trnNo TEXT, tdastinaton TEXT, tstatus TEXT, tvalue REAL, username TEXT, source_station TEXT, dest_station TEXT, network_line TEXT, journey_date TEXT, journey_time TEXT, validity_hours INTEGER DEFAULT 12, valid_until DATETIME, booking_date DATETIME DEFAULT CURRENT_TIMESTAMP, qr_data TEXT)",
                        "CREATE TABLE IF NOT EXISTS cancelbooking (id INTEGER PRIMARY KEY AUTOINCREMENT, cnom TEXT, cdastinaton TEXT, cstatus TEXT, cvalue REAL, username TEXT, bokingstatus TEXT, TrNo TEXT, refund_amount REAL, refund_status TEXT, cancel_time DATETIME DEFAULT CURRENT_TIMESTAMP)",
                        "CREATE TABLE IF NOT EXISTS payment (id INTEGER PRIMARY KEY AUTOINCREMENT, ppayment REAL, pptext TEXT, username TEXT, payment_method TEXT, transaction_id TEXT, payment_status TEXT, payment_date DATETIME DEFAULT CURRENT_TIMESTAMP)",
                        "CREATE TABLE IF NOT EXISTS complaint (id INTEGER PRIMARY KEY AUTOINCREMENT, cname TEXT, cemail TEXT, cmobile TEXT, ccomplaint TEXT, category TEXT, status TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)"
                    ];

                    foreach ($tables as $t) {
                        $this->db->exec($t);
                    }

                    // Seeds
                    $this->db->exec("INSERT OR IGNORE INTO users (id, user_name, password, name, email, mobile) VALUES (1, 'manoj', '202cb962ac59075b964b07152d234b70', 'Manoj Gupta', 'manoj@example.com', '9876543210')");
                    $this->db->exec("INSERT OR IGNORE INTO users (id, user_name, password, name, email, mobile) VALUES (2, 'ela', '202cb962ac59075b964b07152d234b70', 'Ela Sharma', 'ela@example.com', '9876543211')");
                    $this->db->exec("INSERT OR IGNORE INTO admin (id, user_name, password, name, role) VALUES (1, 'admin', '0192023a7bbd73250516f069df18b500', 'WR & CR Admin', 'Chief Commercial Manager')");
                    $this->db->exec("INSERT OR IGNORE INTO admin (id, user_name, password, name, role) VALUES (2, 'manoj_admin', '202cb962ac59075b964b07152d234b70', 'Manoj (Admin)', 'Super Administrator')");

                    // Seed Trains
                    $this->db->exec("INSERT OR IGNORE INTO trains (numbertrain, returnTno, ticketNo, train_name, line, train_type, source, destination, departure_time, arrival_time) VALUES ('WR-90101', 'WR-90102', 'UTS98231', 'Churchgate - Virar Fast Local', 'Western', 'Fast', 'Churchgate', 'Virar', '08:15 AM', '09:35 AM')");
                    $this->db->exec("INSERT OR IGNORE INTO trains (numbertrain, returnTno, ticketNo, train_name, line, train_type, source, destination, departure_time, arrival_time) VALUES ('CR-10101', 'CR-10102', 'UTS98233', 'CSMT - Kalyan Fast Local', 'Central', 'Fast', 'CSMT', 'Kalyan Junction', '08:45 AM', '09:50 AM')");
                    $this->db->exec("INSERT OR IGNORE INTO trains (numbertrain, returnTno, ticketNo, train_name, line, train_type, source, destination, departure_time, arrival_time) VALUES ('HR-20101', 'HR-20102', 'UTS98235', 'CSMT - Panvel Harbour Local', 'Harbour', 'All Stop', 'CSMT', 'Panvel', '09:15 AM', '10:35 AM')");

                    $this->db->exec("INSERT OR IGNORE INTO sstatus (id, ssingle, RReturn, first_class_single, first_class_return, ac_single, ac_return) VALUES (1, 15.00, 30.00, 75.00, 150.00, 95.00, 190.00)");
                    $this->db->exec("INSERT OR IGNORE INTO ordertick (id, ffrom, fto, fdate, fstatus, username, journey_class, network_line, interchange) VALUES (1, 'Churchgate', 'Borivali', '2026-10-31', 'Single', 'Manoj Gupta', 'Second Class', 'Western Line', 'Direct')");
                    $this->db->exec("INSERT OR IGNORE INTO booking (id, tnom, trnNo, tdastinaton, tstatus, tvalue, username, source_station, dest_station, network_line, journey_date, journey_time, validity_hours, valid_until, qr_data) VALUES (1, 'WR-90101', 'UTS98231', 'Churchgate To Borivali', 'Single', 15.00, 'Manoj Gupta', 'Churchgate', 'Borivali', 'Western Line', '2026-10-31', '09:30 AM', 12, datetime('now', '+12 hours'), 'UTS:WR:98231:CCG:BVI:II:15:12H_VALID:CONFIRMED')");
                    $this->db->exec("INSERT OR IGNORE INTO payment (id, ppayment, pptext, username, payment_method, transaction_id, payment_status) VALUES (1, 15.00, 'UPI-REF-983192', 'Manoj Gupta', 'UPI (Google Pay)', 'TXN_WR_84920194', 'SUCCESS')");
                    $this->db->exec("INSERT OR IGNORE INTO complaint (id, cname, cemail, cmobile, ccomplaint, category, status) VALUES (1, 'Manoj Gupta', 'manoj@example.com', '9876543210', 'Request for additional AC local trains during evening peak hours from Churchgate to Virar.', 'Service Request', 'Resolved')");
                }
            }
        }

        if (class_exists('SQLite3')) {
            $conn = new ETicketSQLiteWrapper($sqlite_file);
        }
    }
}
?>
