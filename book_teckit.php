<?php 
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index1.php");
    exit();
}
require_once "db_conn.php";
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                            <i class="fas fa-ticket-simple text-primary"></i> Suburban Ticket Bookings
                        </h1>
                        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary shadow-sm">
                            <i class="fas fa-print fa-sm"></i> Print Report
                        </button>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Master Booking Registry</h6>
                            <span class="badge badge-success"><i class="fas fa-signal"></i> Live Database</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Train No</th>
                                            <th>UTS Ticket Ref</th>
                                            <th>Journey Route</th>
                                            <th>Journey Mode</th>
                                            <th>Fare (INR)</th>
                                            <th>Passenger</th>
                                            <th>Booking Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `booking` ORDER BY id DESC";
                                        $result = $conn->query($sql);
                                        $no = 0;
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $no++;
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td class="font-weight-bold" style="font-family:var(--font-mono);"><?php echo htmlspecialchars($row['tnom']); ?></td>
                                            <td>
                                                <span class="badge badge-info font-weight-bold" style="font-family:var(--font-mono); font-size:0.85rem;">
                                                    <?php echo htmlspecialchars($row['trnNo']); ?>
                                                </span>
                                            </td>
                                            <td class="font-weight-bold"><?php echo htmlspecialchars($row['tdastinaton']); ?></td>
                                            <td><span class="badge badge-primary"><?php echo htmlspecialchars($row['tstatus']); ?></span></td>
                                            <td class="font-weight-bold text-success" style="font-family:var(--font-mono);">
                                                ₹<?php echo number_format((float)$row['tvalue'], 2); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                                            <td><?php echo date('d M Y, h:i A', strtotime($row['booking_date'] ?? 'now')); ?></td>
                                        </tr>
                                        <?php 
                                            }
                                        } else {
                                        ?>
                                        <tr><td colspan="8" class="text-center py-4 text-muted">No ticket bookings recorded yet.</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
