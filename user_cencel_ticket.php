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
                            <i class="fas fa-ban text-danger"></i> Cancelled Tickets & Refunds Registry
                        </h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Suburban Cancellation & Refund Audits</h6>
                            <span class="badge badge-warning">Processed within 24h</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Ticket Ref</th>
                                            <th>Train No</th>
                                            <th>Route</th>
                                            <th>Original Fare</th>
                                            <th>Refund Amount</th>
                                            <th>Passenger</th>
                                            <th>Refund Status</th>
                                            <th>Cancelled On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `cancelbooking` ORDER BY id DESC";
                                        $result = $conn->query($sql);
                                        $no = 0;
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $no++;
                                                $fare = (float)$row['cvalue'];
                                                $refund = isset($row['refund_amount']) ? (float)$row['refund_amount'] : max(0.00, $fare - 5.00);
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td style="font-family:var(--font-mono); font-weight:700; color:var(--wr-crimson);">
                                                <?php echo htmlspecialchars($row['TrNo']); ?>
                                            </td>
                                            <td style="font-family:var(--font-mono); font-weight:600;"><?php echo htmlspecialchars($row['cnom']); ?></td>
                                            <td><?php echo htmlspecialchars($row['cdastinaton']); ?></td>
                                            <td class="text-muted" style="text-decoration:line-through;">₹<?php echo number_format($fare, 2); ?></td>
                                            <td class="font-weight-bold text-success" style="font-family:var(--font-mono);">
                                                ₹<?php echo number_format($refund, 2); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                                            <td><span class="badge badge-success"><i class="fas fa-check"></i> <?php echo htmlspecialchars($row['refund_status'] ?? 'Refund Credited'); ?></span></td>
                                            <td><?php echo date('d M Y, h:i A', strtotime($row['cancel_time'] ?? 'now')); ?></td>
                                        </tr>
                                        <?php 
                                            }
                                        } else {
                                        ?>
                                        <tr><td colspan="9" class="text-center py-4 text-muted">No cancellation records logged.</td></tr>
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
