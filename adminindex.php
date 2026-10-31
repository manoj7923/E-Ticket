<?php 
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index1.php");
    exit();
}
require_once "db_conn.php";

// Fetch Metrics
$u_res = $conn->query("SELECT count(*) as total FROM users");
$u_count = ($u_res && $row = $u_res->fetch_assoc()) ? $row['total'] : 0;

$b_res = $conn->query("SELECT count(*) as total, SUM(tvalue) as revenue FROM booking");
$b_data = ($b_res && $row = $b_res->fetch_assoc()) ? $row : ['total' => 0, 'revenue' => 0];

$c_res = $conn->query("SELECT count(*) as total FROM cancelbooking");
$c_count = ($c_res && $row = $c_res->fetch_assoc()) ? $row['total'] : 0;

$p_res = $conn->query("SELECT count(*) as total FROM payment");
$p_count = ($p_res && $row = $p_res->fetch_assoc()) ? $row['total'] : 0;

$g_res = $conn->query("SELECT count(*) as total FROM complaint");
$g_count = ($g_res && $row = $g_res->fetch_assoc()) ? $row['total'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'Header.php'; ?>
<body id="page-top">

    <div id="wrapper">
        <?php include 'sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'top.php'; ?>

                <div class="container-fluid">
                    <!-- Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                            <i class="fas fa-gauge-high text-primary"></i> Commercial Operations Dashboard
                        </h1>
                        <a href="book_teckit.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-download fa-sm text-white-50"></i> View All Bookings
                        </a>
                    </div>

                    <!-- KPI Cards Row -->
                    <div class="row">
                        <!-- Total Users -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Registered Passengers
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-family:var(--font-mono); font-size:1.6rem;">
                                                <?php echo $u_count; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Bookings -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Confirmed Bookings
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-family:var(--font-mono); font-size:1.6rem;">
                                                <?php echo $b_data['total']; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-ticket-simple fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Revenue -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Suburban Revenue
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-family:var(--font-mono); font-size:1.6rem;">
                                                ₹<?php echo number_format((float)($b_data['revenue'] ?? 0), 2); ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-indian-rupee-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Open Grievances -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Rail Madad Grievances
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-family:var(--font-mono); font-size:1.6rem;">
                                                <?php echo $g_count; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-headset fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Bookings Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-clock-rotate-left"></i> Latest Passenger Bookings
                            </h6>
                            <a href="book_teckit.php" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Train No</th>
                                            <th>Ticket Ref</th>
                                            <th>Route</th>
                                            <th>Mode</th>
                                            <th>Fare</th>
                                            <th>Passenger</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $bk_q = $conn->query("SELECT * FROM booking ORDER BY id DESC LIMIT 5");
                                        $cnt = 0;
                                        if ($bk_q && $bk_q->num_rows > 0) {
                                            while ($row = $bk_q->fetch_assoc()) {
                                                $cnt++;
                                        ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td class="font-weight-bold" style="font-family:var(--font-mono);"><?php echo htmlspecialchars($row['tnom']); ?></td>
                                            <td style="font-family:var(--font-mono); color:var(--wr-blue-600); font-weight:700;"><?php echo htmlspecialchars($row['trnNo']); ?></td>
                                            <td><?php echo htmlspecialchars($row['tdastinaton']); ?></td>
                                            <td><span class="badge badge-info"><?php echo htmlspecialchars($row['tstatus']); ?></span></td>
                                            <td class="font-weight-bold">₹<?php echo number_format((float)$row['tvalue'], 2); ?></td>
                                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                                            <td><?php echo date('d M Y', strtotime($row['booking_date'] ?? 'now')); ?></td>
                                        </tr>
                                        <?php 
                                            }
                                        } else {
                                        ?>
                                        <tr><td colspan="8" class="text-center py-3 text-muted">No booking records found.</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white border-top">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Western Railway Mumbai Suburban Division • E-Ticket Operations System &copy; <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <?php include 'footor.php'; ?>
</body>
</html>
