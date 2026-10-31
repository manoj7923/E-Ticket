-- ========================================================
-- E-Ticket Local Train Ticketing System (IRCTC / UTS Style)
-- Mumbai Suburban Transit Network: Western, Central & Harbour Lines
-- Full Database Schema & Comprehensive Seed Data
-- ========================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+05:30";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Table structure: users
--
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT '',
  `mobile` varchar(20) DEFAULT '',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure: admin
--
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'Chief Commercial Manager',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure: stations (Western, Central & Harbour Lines)
--
CREATE TABLE IF NOT EXISTS `stations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `line` varchar(50) NOT NULL DEFAULT 'Western',
  `distance_km` decimal(5,2) NOT NULL,
  `is_interchange` tinyint(1) DEFAULT 0,
  `interchange_with` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure: trains (Local EMU schedules)
--
CREATE TABLE IF NOT EXISTS `trains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numbertrain` varchar(50) NOT NULL,
  `returnTno` varchar(50) NOT NULL,
  `ticketNo` varchar(50) NOT NULL,
  `train_name` varchar(100) NOT NULL,
  `line` varchar(50) DEFAULT 'Western',
  `train_type` varchar(50) DEFAULT 'Fast',
  `source` varchar(100) DEFAULT 'Churchgate',
  `destination` varchar(100) DEFAULT 'Virar',
  `departure_time` varchar(20) DEFAULT '09:30 AM',
  `arrival_time` varchar(20) DEFAULT '10:55 AM',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure: sstatus (Fare structure reference)
--
CREATE TABLE IF NOT EXISTS `sstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ssingle` decimal(10,2) NOT NULL DEFAULT 15.00,
  `RReturn` decimal(10,2) NOT NULL DEFAULT 30.00,
  `first_class_single` decimal(10,2) DEFAULT 75.00,
  `first_class_return` decimal(10,2) DEFAULT 150.00,
  `ac_single` decimal(10,2) DEFAULT 95.00,
  `ac_return` decimal(10,2) DEFAULT 190.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure: ordertick (Draft search / pending order)
--
CREATE TABLE IF NOT EXISTS `ordertick` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ffrom` varchar(255) NOT NULL,
  `fto` varchar(255) NOT NULL,
  `fdate` varchar(50) NOT NULL,
  `fstatus` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `journey_class` varchar(50) DEFAULT 'Second Class',
  `network_line` varchar(50) DEFAULT 'All Lines',
  `interchange` varchar(100) DEFAULT 'Direct',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure: booking (Confirmed Tickets with 12-Hour Validity)
--
CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tnom` varchar(100) NOT NULL,
  `trnNo` varchar(100) NOT NULL,
  `tdastinaton` varchar(255) NOT NULL,
  `tstatus` varchar(100) NOT NULL,
  `tvalue` decimal(10,2) NOT NULL,
  `username` varchar(255) NOT NULL,
  `source_station` varchar(100) DEFAULT '',
  `dest_station` varchar(100) DEFAULT '',
  `network_line` varchar(50) DEFAULT 'Western Line',
  `journey_date` varchar(50) DEFAULT '',
  `journey_time` varchar(50) DEFAULT '',
  `booking_date` timestamp DEFAULT CURRENT_TIMESTAMP,
  `validity_hours` int(11) DEFAULT 12,
  `valid_until` timestamp NULL DEFAULT NULL,
  `qr_data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure: cancelbooking (Cancelled Tickets)
--
CREATE TABLE IF NOT EXISTS `cancelbooking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cnom` varchar(100) NOT NULL,
  `cdastinaton` varchar(255) NOT NULL,
  `cstatus` varchar(100) NOT NULL,
  `cvalue` decimal(10,2) NOT NULL,
  `username` varchar(255) NOT NULL,
  `bokingstatus` varchar(100) NOT NULL,
  `TrNo` varchar(100) NOT NULL,
  `refund_amount` decimal(10,2) DEFAULT 0.00,
  `refund_status` varchar(50) DEFAULT 'Processed',
  `cancel_time` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure: payment (Transactions)
--
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ppayment` decimal(10,2) NOT NULL,
  `pptext` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `payment_method` varchar(50) DEFAULT 'UPI',
  `transaction_id` varchar(100) DEFAULT '',
  `payment_status` varchar(50) DEFAULT 'SUCCESS',
  `payment_date` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure: complaint (Passenger Grievances / Rail Madad)
--
CREATE TABLE IF NOT EXISTS `complaint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) NOT NULL,
  `cemail` varchar(255) NOT NULL,
  `cmobile` varchar(50) NOT NULL,
  `ccomplaint` text NOT NULL,
  `category` varchar(50) DEFAULT 'General',
  `status` varchar(50) DEFAULT 'In Progress',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================================
-- Seed Data
-- ========================================================

-- Users (Default password '123' -> MD5 202cb962ac59075b964b07152d234b70)
INSERT INTO `users` (`id`, `user_name`, `password`, `name`, `email`, `mobile`) VALUES
(1, 'manoj', '202cb962ac59075b964b07152d234b70', 'Manoj Gupta', 'manoj@example.com', '9876543210'),
(2, 'ela', '202cb962ac59075b964b07152d234b70', 'Ela Sharma', 'ela@example.com', '9876543211'),
(3, 'elias', '202cb962ac59075b964b07152d234b70', 'Elias Khan', 'elias@example.com', '9876543212')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Admin
INSERT INTO `admin` (`id`, `user_name`, `password`, `name`, `role`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'WR & CR Commercial Admin', 'Chief Commercial Manager'),
(2, 'manoj_admin', '202cb962ac59075b964b07152d234b70', 'Manoj (Admin)', 'Super Administrator')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- ========================================================
-- 1. Western Line Stations (Churchgate - Dahanu Road)
-- ========================================================
INSERT INTO `stations` (`code`, `name`, `line`, `distance_km`, `is_interchange`, `interchange_with`) VALUES
('CCG', 'Churchgate', 'Western', 0.0, 0, ''),
('MEL', 'Marine Lines', 'Western', 1.4, 0, ''),
('CYR', 'Charni Road', 'Western', 2.3, 0, ''),
('GTR', 'Grant Road', 'Western', 3.7, 0, ''),
('MMCT', 'Mumbai Central', 'Western', 4.7, 0, ''),
('MX', 'Mahalaxmi', 'Western', 6.0, 0, ''),
('PL', 'Lower Parel', 'Western', 7.5, 0, ''),
('PBHD', 'Prabhadevi', 'Western', 8.8, 1, 'Central Line (Parel)'),
('DDR', 'Dadar (WR)', 'Western', 10.2, 1, 'Central Line (Dadar CR)'),
('MRU', 'Matunga Road', 'Western', 11.4, 0, ''),
('MM', 'Mahim Junction', 'Western', 12.8, 1, 'Harbour Line Branch'),
('BA', 'Bandra', 'Western', 14.8, 1, 'Harbour Line Branch'),
('KHAR', 'Khar Road', 'Western', 16.5, 0, ''),
('STC', 'Santacruz', 'Western', 18.0, 0, ''),
('VLP', 'Vile Parle', 'Western', 19.8, 0, ''),
('ADH', 'Andheri', 'Western', 21.8, 1, 'Harbour Line Branch & Metro 1'),
('JOS', 'Jogeshwari', 'Western', 24.2, 0, ''),
('RMAR', 'Ram Mandir', 'Western', 25.8, 0, ''),
('GMN', 'Goregaon', 'Western', 27.0, 1, 'Harbour Line Branch Terminus'),
('MDD', 'Malad', 'Western', 29.8, 0, ''),
('KNDI', 'Kandivali', 'Western', 31.8, 0, ''),
('BVI', 'Borivali', 'Western', 34.2, 0, ''),
('DIC', 'Dahisar', 'Western', 36.8, 0, ''),
('MIRA', 'Mira Road', 'Western', 40.5, 0, ''),
('BYR', 'Bhayandar', 'Western', 43.8, 0, ''),
('NIG', 'Naigaon', 'Western', 48.0, 0, ''),
('BSR', 'Vasai Road', 'Western', 52.0, 1, 'Central Line (Diva Link)'),
('NSP', 'Nala Sopara', 'Western', 56.2, 0, ''),
('VR', 'Virar', 'Western', 60.0, 0, ''),
('VTN', 'Vaitarna', 'Western', 69.5, 0, ''),
('SAH', 'Saphale', 'Western', 76.5, 0, ''),
('KLV', 'Kelve Road', 'Western', 83.2, 0, ''),
('PLG', 'Palghar', 'Western', 91.5, 0, ''),
('UOI', 'Umroli', 'Western', 98.0, 0, ''),
('BOR', 'Boisar', 'Western', 103.0, 0, ''),
('VGN', 'Vangaon', 'Western', 112.5, 0, ''),
('DRD', 'Dahanu Road', 'Western', 124.0, 0, '')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- ========================================================
-- 2. Central Line Stations (CSMT - Kalyan / Kasara / Karjat)
-- ========================================================
INSERT INTO `stations` (`code`, `name`, `line`, `distance_km`, `is_interchange`, `interchange_with`) VALUES
('CSMT_CR', 'CSMT (Central)', 'Central', 0.0, 1, 'Harbour Line (CSMT)'),
('MSD_CR', 'Masjid (CR)', 'Central', 1.5, 1, 'Harbour Line (Masjid)'),
('SNRD_CR', 'Sandhurst Road (CR)', 'Central', 2.5, 1, 'Harbour Line (Sandhurst Rd)'),
('BY', 'Byculla', 'Central', 4.0, 0, ''),
('CHG', 'Chinchpokli', 'Central', 5.2, 0, ''),
('CRD', 'Currey Road', 'Central', 6.3, 0, ''),
('PR', 'Parel', 'Central', 7.5, 1, 'Western Line (Prabhadevi)'),
('DDR_CR', 'Dadar (CR)', 'Central', 9.0, 1, 'Western Line (Dadar WR)'),
('MTN', 'Matunga', 'Central', 10.5, 0, ''),
('SIN', 'Sion', 'Central', 13.0, 0, ''),
('CLA_CR', 'Kurla (CR)', 'Central', 15.5, 1, 'Harbour Line (Kurla HR)'),
('VVH', 'Vidyavihar', 'Central', 17.5, 0, ''),
('GC', 'Ghatkopar', 'Central', 19.5, 1, 'Metro 1 (Versova-Ghatkopar)'),
('VK', 'Vikhroli', 'Central', 23.0, 0, ''),
('KJMG', 'Kanjurmarg', 'Central', 25.0, 0, ''),
('BND', 'Bhandup', 'Central', 27.0, 0, ''),
('NHU', 'Nahur', 'Central', 29.0, 0, ''),
('MLND', 'Mulund', 'Central', 31.0, 0, ''),
('TNA', 'Thane', 'Central', 34.0, 1, 'Trans-Harbour (Vashi/Panvel)'),
('KLVA', 'Kalva', 'Central', 36.5, 0, ''),
('MBQ', 'Mumbra', 'Central', 40.0, 0, ''),
('DIVA', 'Diva Junction', 'Central', 43.0, 1, 'Western Line (Vasai Link)'),
('KOPR', 'Kopar', 'Central', 47.0, 0, ''),
('DI', 'Dombivli', 'Central', 48.5, 0, ''),
('THK', 'Thakurli', 'Central', 50.5, 0, ''),
('KYN', 'Kalyan Junction', 'Central', 54.0, 1, 'Kasara & Karjat Routes'),
('TLA', 'Titwala', 'Central', 67.0, 0, ''),
('ASO', 'Asangaon', 'Central', 85.0, 0, ''),
('KSRA', 'Kasara', 'Central', 121.0, 0, ''),
('ABH', 'Ambernath', 'Central', 60.0, 0, ''),
('BUD', 'Badlapur', 'Central', 68.0, 0, ''),
('KJT', 'Karjat', 'Central', 100.0, 0, '')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- ========================================================
-- 3. Harbour Line Stations (CSMT - Panvel / Wadala Branch)
-- ========================================================
INSERT INTO `stations` (`code`, `name`, `line`, `distance_km`, `is_interchange`, `interchange_with`) VALUES
('CSMT_HR', 'CSMT (Harbour)', 'Harbour', 0.0, 1, 'Central Line (CSMT)'),
('DKRD', 'Dockyard Road', 'Harbour', 3.8, 0, ''),
('RRD', 'Reay Road', 'Harbour', 4.9, 0, ''),
('CTGN', 'Cotton Green', 'Harbour', 5.9, 0, ''),
('SVE', 'Sewri', 'Harbour', 7.2, 0, ''),
('VDLR', 'Vadala Road', 'Harbour', 9.3, 1, 'Western Line Branch (Bandra/Andheri)'),
('GTBN', 'GTB Nagar', 'Harbour', 11.5, 0, ''),
('CHF', 'Chunabhatti', 'Harbour', 13.0, 0, ''),
('CLA_HR', 'Kurla (Harbour)', 'Harbour', 15.0, 1, 'Central Line (Kurla CR)'),
('TKNG', 'Tilak Nagar', 'Harbour', 17.0, 0, ''),
('CMBR', 'Chembur', 'Harbour', 18.5, 0, ''),
('GV', 'Govandi', 'Harbour', 20.0, 0, ''),
('MNKD', 'Mankhurd', 'Harbour', 22.0, 0, ''),
('VSH', 'Vashi', 'Harbour', 29.0, 1, 'Trans-Harbour (Thane)'),
('SNCR', 'Sanpada', 'Harbour', 31.0, 1, 'Trans-Harbour (Thane)'),
('JNJ', 'Juinagar', 'Harbour', 33.0, 1, 'Trans-Harbour (Thane)'),
('NEU', 'Nerul', 'Harbour', 35.5, 1, 'Trans-Harbour (Thane)'),
('SWDV', 'Seawoods-Darave', 'Harbour', 38.0, 0, ''),
('BEPR', 'Belapur CBD', 'Harbour', 41.0, 0, ''),
('KHAG', 'Kharghar', 'Harbour', 44.5, 0, ''),
('MANR', 'Mansarovar', 'Harbour', 47.5, 0, ''),
('KNDS', 'Khandeshwar', 'Harbour', 50.0, 0, ''),
('PNVL', 'Panvel', 'Harbour', 53.0, 1, 'Trans-Harbour & Konkan Rly')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Local Trains
INSERT INTO `trains` (`numbertrain`, `returnTno`, `ticketNo`, `train_name`, `line`, `train_type`, `source`, `destination`, `departure_time`, `arrival_time`) VALUES
('WR-90101', 'WR-90102', 'UTS98231', 'Churchgate - Virar Fast Local', 'Western', 'Fast', 'Churchgate', 'Virar', '08:15 AM', '09:35 AM'),
('WR-90215', 'WR-90216', 'UTS98232', 'Churchgate - Borivali Slow Local', 'Western', 'Slow', 'Churchgate', 'Borivali', '08:30 AM', '09:38 AM'),
('CR-10101', 'CR-10102', 'UTS98233', 'CSMT - Kalyan Fast Local', 'Central', 'Fast', 'CSMT', 'Kalyan Junction', '08:45 AM', '09:50 AM'),
('CR-10218', 'CR-10219', 'UTS98234', 'CSMT - Thane Slow Local', 'Central', 'Slow', 'CSMT', 'Thane', '09:00 AM', '09:55 AM'),
('HR-20101', 'HR-20102', 'UTS98235', 'CSMT - Panvel Harbour Local', 'Harbour', 'All Stop', 'CSMT', 'Panvel', '09:15 AM', '10:35 AM'),
('WR-90342', 'WR-90343', 'UTS98236', 'Churchgate - Dahanu AC Local', 'Western', 'AC Fast', 'Churchgate', 'Dahanu Road', '09:30 AM', '11:45 AM')
ON DUPLICATE KEY UPDATE `train_name`=VALUES(`train_name`);

-- Default fare rates reference
INSERT INTO `sstatus` (`id`, `ssingle`, `RReturn`, `first_class_single`, `first_class_return`, `ac_single`, `ac_return`) VALUES
(1, 15.00, 30.00, 75.00, 150.00, 95.00, 190.00)
ON DUPLICATE KEY UPDATE `ssingle`=VALUES(`ssingle`);

-- Initial sample order & booking
INSERT INTO `ordertick` (`id`, `ffrom`, `fto`, `fdate`, `fstatus`, `username`, `journey_class`, `network_line`, `interchange`) VALUES
(1, 'Churchgate', 'Borivali', '2026-10-31', 'Single', 'Manoj Gupta', 'Second Class', 'Western Line', 'Direct')
ON DUPLICATE KEY UPDATE `ffrom`=VALUES(`ffrom`);

INSERT INTO `booking` (`id`, `tnom`, `trnNo`, `tdastinaton`, `tstatus`, `tvalue`, `username`, `source_station`, `dest_station`, `network_line`, `journey_date`, `journey_time`, `validity_hours`, `valid_until`, `qr_data`) VALUES
(1, 'WR-90101', 'UTS98231', 'Churchgate To Borivali', 'Single', 15.00, 'Manoj Gupta', 'Churchgate', 'Borivali', 'Western Line', '2026-10-31', '09:30 AM', 12, DATE_ADD(NOW(), INTERVAL 12 HOUR), 'UTS:WR:98231:CCG:BVI:II:15:12H_VALID:CONFIRMED')
ON DUPLICATE KEY UPDATE `tnom`=VALUES(`tnom`);

INSERT INTO `payment` (`id`, `ppayment`, `pptext`, `username`, `payment_method`, `transaction_id`, `payment_status`) VALUES
(1, 15.00, 'UPI-REF-983192', 'Manoj Gupta', 'UPI (Google Pay)', 'TXN_WR_84920194', 'SUCCESS')
ON DUPLICATE KEY UPDATE `ppayment`=VALUES(`ppayment`);

INSERT INTO `complaint` (`id`, `cname`, `cemail`, `cmobile`, `ccomplaint`, `category`, `status`) VALUES
(1, 'Manoj Gupta', 'manoj@example.com', '9876543210', 'Request for additional AC local trains during evening peak hours from Churchgate to Virar.', 'Service Request', 'Resolved')
ON DUPLICATE KEY UPDATE `cname`=VALUES(`cname`);

COMMIT;
